<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\Http\Requests\CreateSimulationRequest;
use DigicoSimulation\Http\Requests\GenerateSimulationRequest;
use DigicoSimulation\Http\Requests\UpdateSimulationRequest;
use DigicoSimulation\Http\Resources\SimulationResource;
use DigicoSimulation\Jobs\CopyFileToGoogleDriveJob;
use DigicoSimulation\Services\Google\GoogleDriveService;
use DigicoSimulation\Services\Google\GoogleSheetService;
use DigicoSimulation\Services\SimulationInputService;
use DigicoSimulation\Services\SimulationEntryService;
use DigicoSimulation\Services\SimulationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    private SimulationInputService $simulationInputService;
    private SimulationEntryService $simulationEntryService;
    private SimulationService $simulationService;
    public function __construct()
    {
        $this->simulationInputService = new SimulationInputService();
        $this->simulationEntryService = new SimulationEntryService();
        $this->simulationService = new SimulationService();
    }

    public function show(string $simulationId) : array
    {
        $simulation = $this->simulationService->get($simulationId);
        $entries = $this->simulationEntryService->getSimulationEntries($simulationId);

        return [
            'current_step' => $simulation->current_step,
            'entries' => $entries
        ];
    }

    public function store(CreateSimulationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $simulationId = $this->simulationService->create($data['current_step']);
        /*$driveService = new GoogleDriveService();
        $spreadsheet_id = $driveService->copyFile();
        $this->simulationService->linkSpreadsheetIdToSimulation($simulationId, $spreadsheet_id);*/

        /*$tenant = tenancy()->tenant;
        tenancy()->initialize($tenant);*/
        CopyFileToGoogleDriveJob::dispatch($simulationId, new GoogleDriveService(), $this->simulationService);

        return response()->json([
            'message' => 'Simulation created successfully',
            'id' => $simulationId,
        ], 201);
    }

    public function update(UpdateSimulationRequest $request, string $simulationId): JsonResponse //TODO Faire un gros try catch avec les items et vérifier s'ils existent (question comprise)
    {
        //TODO FAIRE DES TRANSACTIONS
        $data = $request->validated();
        if ($data['values'] == null || $data['values'] == [])
        {
            return response()->json("Renvoyé car 0 valeur"); //TODO
        }

        if (!$this->simulationService->exists($simulationId))
        {
            //TODO Faire une vérification si une spreadsheet est liée ?
            throw new \Exception("La simulation n'existe pas : " . $simulationId); //TODO faire une réponse appropriée
        }

        $this->simulationService->updateCurrentStep($simulationId, $data['current_step']);

        foreach ($data['values'] as $entry)
        {
            $label = $entry['label'];
            $value = $entry['response'];

            $input = $this->simulationInputService->findQuestionFromLabel($label);
            if ($input == null)
            {
                throw new \Exception("La question n'existe pas : " .  $label);
            }

            $this->simulationEntryService->newOrUpdate($simulationId, $input->label, $value);
        }

        return response()->json();
    }

    public function generate(GenerateSimulationRequest $request) : JsonResponse
    {
        $time_start = microtime(true);

        $data = $request->validated();
        $simulationId = $data['simulation_id'];

        $entries = $this->simulationEntryService->getCellValueMap($simulationId);
        $spreadsheetId = $this->simulationService->getSpreadsheetId($simulationId);

        $sheetService = new GoogleSheetService();
        $sheetService->write($spreadsheetId, "Input", $entries);

        $ranges = ['B4:C14'];

        $sheetValues = $sheetService->read($spreadsheetId, "Output BLEU", $ranges);
        $time_end = microtime(true);


        $returnValues = $sheetValues[0]->values;

        return response()->json($returnValues);
    }
}

<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\Http\Requests\CreateSimulationRequest;
use DigicoSimulation\Http\Requests\GenerateSimulationRequest;
use DigicoSimulation\Http\Requests\UpdateSimulationRequest;
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

    public function show(string $simulationId)
    {

    }

    public function store(CreateSimulationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $simulationId = $this->simulationService->create($data['current_step']);
        $driveService = new GoogleDriveService();
        $spreadsheet_id = $driveService->copyFile();
        $this->simulationService->linkSpreadsheetIdToSimulation($simulationId, $spreadsheet_id);
        //CopyFileToGoogleDriveJob::dispatch($simulationId, new GoogleDriveService(), $this->simulationService); TODO à changer pour utiliser le job

        return response()->json([
            'message' => 'Simulation created successfully',
            'id' => $simulationId,
        ], 201);
    }

    public function update(UpdateSimulationRequest $request, string $simulationId): JsonResponse //TODO Faire un gros try catch avec les items et vérifier s'ils existent (question comprise)
    {
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

        $entries = $this->simulationEntryService->getSimulationEntries($simulationId);
        $spreadsheetId = $this->simulationService->getSpreadsheetId($simulationId);

        $sheetService = new GoogleSheetService();
        $sheetService->write($spreadsheetId, "Input", $entries);

        $ranges = ['C4:C14'];

        $returnValues = $sheetService->read($spreadsheetId, "Output BLEU", $ranges);
        $time_end = microtime(true);

        return response()->json($time_end - $time_start);
    }
}

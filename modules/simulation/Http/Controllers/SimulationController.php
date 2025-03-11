<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\Http\Requests\CreateSimulationRequest;
use DigicoSimulation\Http\Requests\UpdateSimulationRequest;
use DigicoSimulation\Services\Google\GoogleDriveService;
use DigicoSimulation\Services\QuestionService;
use DigicoSimulation\Services\SimulationEntryService;
use DigicoSimulation\Services\SimulationService;
use Illuminate\Http\JsonResponse;

class SimulationController extends Controller
{
    private QuestionService $questionService;
    private SimulationEntryService $simulationEntryService;
    private SimulationService $simulationService;
    public function __construct()
    {
        $this->questionService = new QuestionService();
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
        if ($data['response'] == null)
        {
            return response()->json("Renvoyé car 0 valeur"); //TODO
        }
        if (!$this->simulationService->exists($simulationId))
        {
            //TODO Faire une vérification si une spreadsheet est liée ?
            throw new \Exception("La simulation n'existe pas"); //TODO faire une réponse appropriée
        }

        $question = $this->questionService->findQuestionFromLabel($data['label']);
        if ($question == null)
        {
            throw new \Exception("La question n'existe pas : " . $data['label']);
        }

        $test = $this->simulationEntryService->newOrUpdate($simulationId, $question->label, $data['response']);

        return response()->json($test);
    }
}

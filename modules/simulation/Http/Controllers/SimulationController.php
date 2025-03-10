<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\Http\Requests\CreateSimulationRequest;
use DigicoSimulation\Http\Requests\UpdateSimulationRequest;
use DigicoSimulation\Http\Resources\SuccessfulCreationResource;
use DigicoSimulation\Jobs\CopyFileToGoogleDriveJob;
use DigicoSimulation\Models\Simulation;
use DigicoSimulation\Services\Google\GoogleDriveService;
use DigicoSimulation\Services\QuestionService;
use DigicoSimulation\Services\SimulationEntryService;
use DigicoSimulation\Services\SimulationService;
use Illuminate\Http\JsonResponse;
use Illuminate\http\Request;

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
            'simulation_id' => $simulationId,
        ], 201);
    }

    public function update(UpdateSimulationRequest $request, string $spreadsheet_id): JsonREsponse
    {
        $data = $request->validated();
        if ($spreadsheet_id == "")
        {
            $driveService = new GoogleDriveService();
            $spreadsheet_id = $driveService->copyFile();

            Simulation::create([
                'spreadsheet_id' => $spreadsheet_id,
                'current_step' => 'installationType',
            ]);
        }
        else if (!$this->simulationService->exists($spreadsheet_id))
        {
            throw new \Exception("La spreadsheet n'existe pas");
        }

        $question = $this->questionService->findQuestionFromLabel($data['label']);
        $this->simulationEntryService->newEntry($spreadsheet_id, $question->label, $data['response']);

        return response()->json($question);
    }
}

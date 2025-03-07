<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\Http\Requests\UpdateSimulationRequest;
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
    public function store(Request $request): JsonResponse
    {
        return response()->json("Submit du form");
    }

    public function update(UpdateSimulationRequest $request, string $spreadsheet_id): mixed
    {
        $data = $request->validated();

        if ($spreadsheet_id == "0") //TODO verif si null ?
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

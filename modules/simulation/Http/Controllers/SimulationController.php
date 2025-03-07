<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\Http\Requests\CreateSimulationRequest;
use DigicoSimulation\Http\Requests\UpdateSimulationRequest;
use DigicoSimulation\Http\Resources\SuccessfulCreationResource;
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
        $driveService = new GoogleDriveService();
        $spreadsheetId = $driveService->copyFile();
        $this->simulationService->create($spreadsheetId, $data['current_step']);

        return response()->json([
            'message' => 'Simulation created successfully',
            'simulation_id' => $spreadsheetId,
        ], 201); //TODO Soucis, la copie prend du temps et on ne peut pas avancer sur le formulaire si l'id de simulation est ceui du spread
    }

    public function update(UpdateSimulationRequest $request, string $spreadsheet_id): JsonREsponse
    {
        $data = $request->validated();
        if ($spreadsheet_id == "") //TODO Utiliser dnas le front les onSuccess des useMutation pour pouvoir enchainer les méthodes
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

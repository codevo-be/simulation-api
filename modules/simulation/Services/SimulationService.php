<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\Simulation;

class SimulationService
{

    public function create($currentStep)
    {
        $simulation =  Simulation::create([
            'current_step' => $currentStep,
        ]);

        return $simulation->id;
    }

    public function exists(string $simulationId): bool
    {
        return Simulation::where('id', $simulationId)->exists();
    }

    public function linkSpreadsheetIdToSimulation(string $simulationId, string $spreadsheet_id): void
    {
        $simulation = Simulation::where('id',  $simulationId)->first();
        $simulation->spreadsheet_id = $spreadsheet_id;
        $simulation->save();
    }

    public function getSpreadsheetId($simulationId)
    {
        $result = Simulation::where('id', $simulationId)->first('spreadsheet_id');
        return $result->spreadsheet_id;
    }

    public function updateCurrentStep($simulationId, $currentStep)
    {
        Simulation::where('id', $simulationId)->update(['current_step' => $currentStep]);
    }
}

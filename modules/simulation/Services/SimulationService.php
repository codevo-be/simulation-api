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

    public function exists(string $spreadsheet_id): bool
    {
        return Simulation::where('spreadsheet_id', $spreadsheet_id)->exists();
    }

    public function linkSpreadsheetIdToSimulation(string $simulationId, string $spreadsheet_id): void
    {
        $simulation = Simulation::where('id',  $simulationId)->first();
        $simulation->spreadsheet_id = $spreadsheet_id;
        $simulation->save();
    }
}

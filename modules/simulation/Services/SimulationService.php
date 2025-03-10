<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\Simulation;

class SimulationService
{

    public function create($spreadsheetId, $currentStep)
    {
        $simulation =  Simulation::create([
            'spreadsheet_id' => $spreadsheetId,
            'current_step' => $currentStep,
        ]);

        return $simulation->id;
    }

    public function exists(string $spreadsheet_id): bool
    {
        return Simulation::where('spreadsheet_id', $spreadsheet_id)->exists();
    }
}

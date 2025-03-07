<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\Simulation;

class SimulationService
{

    public function create($spreadsheetId, $currentStep): void
    {
        Simulation::create([
            'spreadsheet_id' => $spreadsheetId,
            'current_step' => $currentStep,
        ]);
    }

    public function exists(string $spreadsheet_id): bool
    {
        return Simulation::where('spreadsheet_id', $spreadsheet_id)->exists();
    }
}

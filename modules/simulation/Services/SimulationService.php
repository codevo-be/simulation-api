<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\Simulation;

class SimulationService
{

    public function exists(string $spreadsheet_id): bool
    {
        return Simulation::where('spreadsheet_id', $spreadsheet_id)->exists();
    }
}

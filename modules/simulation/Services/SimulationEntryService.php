<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\SimulationEntry;

class SimulationEntryService
{
    public function newEntry(string $simulationId, string $label, string $response): SimulationEntry //TODO changer en id
    {
        return SimulationEntry::create([
            'simulation_id' => $simulationId,
            'label' => $label,
            'response' => $response
        ]);
    }
}

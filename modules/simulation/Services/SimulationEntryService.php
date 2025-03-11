<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\SimulationEntry;

class SimulationEntryService
{
    public function newOrUpdate(string $simulationId, string $label, string $response): SimulationEntry
    {
        return SimulationEntry::updateOrCreate(
            ['simulation_id' => $simulationId, 'label' => $label], // Match condition
            ['response' => $response] // Update or create with this data
        );
    }

    public function exists(string $simulationId, string $label): bool
    {
        return SimulationEntry::where('simulation_id', $simulationId)->where('label', $label)->exists();
    }

    public function getSimulationEntries($simulationId)
    {
        return SimulationEntry::join('questions as q', 'simulation_entries.label', '=', 'q.label')
            ->where('simulation_entries.simulation_id', $simulationId)
            ->orderBy('q.cell_reference')
            ->select('simulation_entries.response', 'q.cell_reference')
            ->get();
    }
}

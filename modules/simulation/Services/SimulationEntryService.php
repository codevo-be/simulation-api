<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\SimulationEntry;

class SimulationEntryService
{
    public function newOrUpdate(string $simulationId, string $label, string $response): SimulationEntry
    {
        if ($this->exists($simulationId, $label))
        {
            $entry = SimulationEntry::
                where('simulation_id', $simulationId)
                ->where('label', $label)
                ->first();
            $entry->response = $response;
            $entry->save();
            return $entry;
        }

        return SimulationEntry::create([
            'simulation_id' => $simulationId,
            'label' => $label,
            'response' => $response
        ]);
    }

    public function exists(string $simulationId, string $label): bool
    {
        return SimulationEntry::where('simulation_id', $simulationId)->where('label', $label)->exists();
    }
}

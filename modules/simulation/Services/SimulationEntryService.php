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
        return SimulationEntry::join('simulation_inputs as si', 'simulation_entries.label', '=', 'si.label')
            ->where('simulation_entries.simulation_id', $simulationId)
            ->whereNotNull('si.cell_reference')
            ->orderBy('si.cell_reference')
            ->pluck('simulation_entries.response', 'si.cell_reference');
    }

    public function addContactInformation($simulationId, $email, $phoneNumber, $country, $zipcode)
    {
        $contactData = [
            'contactEmail' => $email,
            'contactPhone' => $phoneNumber,
            'contactCountry' => $country,
            'contactZipCode' => $zipcode,
        ];

        foreach ($contactData as $label => $value) {
            $this->newOrUpdate($simulationId, $label, $value);
        }
    }

}

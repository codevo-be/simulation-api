<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\SimulationEntry;

class SimulationEntryService
{
    public function newEntry(string $spreadsheetId, string $label, string $response): SimulationEntry //TODO changer en id
    {
        return SimulationEntry::create([
            'spreadsheet_id' => $spreadsheetId,
            'label' => $label,
            'response' => $response
        ]);
    }
}

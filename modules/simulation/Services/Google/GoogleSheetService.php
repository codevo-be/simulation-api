<?php

namespace DigicoSimulation\Services\Google;

use DigicoSimulation\GoogleClient;
use Google\Service\Sheets;

class GoogleSheetService
{
    private GoogleClient $client;
    public function __construct()
    {
        $this->client = new GoogleClient();
    }

    public function read($spreadsheetId, $sheetName, $range)
    {

    }

    public function write($spreadsheetId, $sheetName, $data)
    {
        $values = [];
        $rangeList = [];

        foreach ($data as $entry)
        {
            $values[] =  [$entry->response];
            $rangeList[] = $sheetName."!".$entry->cell_reference;
        }

        $sheet = new Sheets($this->client);

        $requests = [];
        foreach ($rangeList as $index => $range) {
            $requests[] = new \Google\Service\Sheets\ValueRange([
                'range' => $range,
                'values' => [$values[$index]]
            ]);
        }

        $body = new \Google\Service\Sheets\BatchUpdateValuesRequest([
            'valueInputOption' => 'RAW',
            'data' => $requests
        ]);

        try {
            $sheet->spreadsheets_values->batchUpdate($spreadsheetId, $body);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

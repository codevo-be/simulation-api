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
        $sheet = new Sheets($this->client);
        $requests = [];

        foreach ($data as $cell => $value) {
            $requests[] = new \Google\Service\Sheets\ValueRange([
                'range' => $sheetName . "!" . $cell,
                'values' => [[$value]]
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

<?php

namespace DigicoSimulation\Services\Google;

use DigicoSimulation\GoogleClient;

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

    public function write()
    {

    }
}

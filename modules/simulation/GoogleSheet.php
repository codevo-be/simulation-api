<?php

namespace DigicoSimulation;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheet
{
    private GoogleClient $client;
    private Sheets $sheet;
    private DriveFile $drawer;
    private const SHEET_ID = "10FIqjo-qRL02UDmj8URqlAbJWGrI-2QSwO1-NuQdoi8";
    //private const SHEET_ID = "1cpFjWHUXFKcqgoJ4IoPe09cMiTVI3RZYHxwDLb1StCY";
    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->sheet = new Sheets($this->client);
        $this->drawer = new DriveFile();
    }


    public function handle()
    {
        try
        {
            $googleSheet = new GoogleSheet();
        } catch (\Exception $e)
        {

        }
    }

    public function readValues($sheet = "output")
    {
        return $this->sheet->spreadsheets_values->get(self::SHEET_ID, 'Input');
    }

    public function replaceSheetData()
    {
        $range = 'Input!D3:D13'; // Spécifie la plage à mettre à jour
        $values = [
            [700],
            [500],
            ["Plat"],
            [100000],
            ["Est"],
            ["Je ne connais pas"],
            ["Oui"],
            [400],
            [15],
            ["NoveWay réalise toute l'installation"],
            ["Sheet"]
        ];

        $body = new ValueRange([
            'values' => $values
        ]);

        $params = ['valueInputOption' => 'RAW'];

        // Appel à l'API pour mettre à jour les données
        $this->sheet->spreadsheets_values->update(
            self::SHEET_ID,
            $range,
            $body,
            $params
        );
    }
}

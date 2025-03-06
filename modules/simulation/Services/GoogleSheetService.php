<?php

namespace DigicoSimulation\Services;

use Revolution\Google\Sheets\Facades\Sheets;

class GoogleSheetService
{
    protected string $spreadSheetId;

    public function __construct()
    {
        $this->spreadSheetId = config('google.spreadsheet_id');
    }

    public function readSheet($sheetName)
    {
        return Sheets::spreadsheet($this->spreadSheetId)
            ->sheet($sheetName)
            ->get();
    }

    public function writeToSheet($sheetName, array $data)
    {
        return Sheets::spreadsheet($this->spreadSheetId)
            ->sheet($sheetName)
            ->append($data);
    }

    public function updateSheet($sheetName, $range, array $data)
    {
        return Sheets::spreadsheet($this->spreadSheetId)
            ->sheet($sheetName)
            ->range($range)
            ->update($data);
    }
}

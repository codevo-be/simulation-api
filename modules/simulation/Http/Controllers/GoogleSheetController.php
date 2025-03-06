<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\GoogleSheet;
use Illuminate\Http\JsonResponse;

class GoogleSheetController extends Controller
{
    private GoogleSheet $sheet;
    public function __construct()
    {
        $this->sheet = new GoogleSheet();
    }

    public function test(): JsonResponse
    {
        $start_test = microtime(true);
        //$this->sheet->replaceSheetData();
        //$test = $this->sheet->readValues("Input");
        sleep(1);
        $end_test = microtime(true);

        return response()->json(($end_test - $start_test));
    }
}

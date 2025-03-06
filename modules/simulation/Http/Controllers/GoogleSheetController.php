<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\GoogleDrive;
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
        $this->sheet->replaceSheetData();
        $test = $this->sheet->readValues("Input");
        $end_test = microtime(true);

        return response()->json($test);
    }

    public function createFolder(): JSonResponse
    {
        $start_test = microtime(true);
        $googleDrive = new  GoogleDrive();
        $folders = $googleDrive->copySheetToDrive("1cpFjWHUXFKcqgoJ4IoPe09cMiTVI3RZYHxwDLb1StCY", "1q6TwRMot15jwSB1ni8Hl2ysWJ7TEwm7z");
        //return  response()->json($folders);
        $end_test = microtime(true);
        return response()->json($end_test -  $start_test);
    }
}

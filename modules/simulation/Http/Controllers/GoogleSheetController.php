<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use DigicoSimulation\Services\GoogleSheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GoogleSheetController extends Controller
{
    protected GoogleSheetService $googleSheetsService;

    public function __construct()
    {
        $this->googleSheetsService = new GoogleSheetService();
    }

    public function read(): JsonResponse
    {
        $data = $this->googleSheetsService->readSheet('Feuille1');
        return response()->json($data);
    }

    public function write()
    {
        $data = [
            ['Nom', 'Âge', 'Ville'],
            ['Alice', 25, 'Paris'],
            ['Bob', 30, 'Lyon']
        ];

        $this->googleSheetsService->writeSheet('Feuille2', $data);

        return response()->json(['message' => 'Données ajoutées avec succès']);
    }

    public function test(): JsonResponse
    {
        return response()->json(['message' => 'Test réussi']);
    }
}

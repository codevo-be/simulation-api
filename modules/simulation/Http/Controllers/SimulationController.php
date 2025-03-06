<?php

namespace DigicoSimulation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\http\Request;

class SimulationController extends Controller
{
    public function create(Request $request): void
    {
        dump($request);
    }
}

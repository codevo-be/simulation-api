<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\SimulationInput;

class SimulationInputService
{
    public function findQuestionFromLabel($label)
    {
        return SimulationInput::where('label', $label)->first();
    }
}

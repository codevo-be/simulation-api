<?php

namespace DigicoSimulation\Models;

use Illuminate\Database\Eloquent\Model;

class SimulationEntry extends Model
{
    protected $fillable = [
        'simulation_id',
        'label',
        'response'
    ];
}

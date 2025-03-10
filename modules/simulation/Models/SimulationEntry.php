<?php

namespace DigicoSimulation\Models;

use Illuminate\Database\Eloquent\Model;

class SimulationEntry extends Model
{
    public $incrementing = false;
    protected $primaryKey = ['simulation_id', 'label'];
    protected $keyType = 'string';

    protected $fillable = [
        'simulation_id',
        'label',
        'response'
    ];
}

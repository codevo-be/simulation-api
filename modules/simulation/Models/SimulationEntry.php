<?php

namespace DigicoSimulation\Models;

use Illuminate\Database\Eloquent\Model;

class SimulationEntry extends Model
{
    public $incrementing = false;
    protected $primaryKey = ['spreadsheet_id', 'label'];
    protected $keyType = 'string';

    protected $fillable = [
        'spreadsheet_id',
        'label',
        'response'
    ];
}

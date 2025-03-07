<?php

namespace DigicoSimulation\Models;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    protected $primaryKey = 'spreadsheet_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'contact_id' => null,
        'status' => 'draft',
    ];

    protected $fillable = [
        'current_step',
        'spreadsheet_id'
    ];
}

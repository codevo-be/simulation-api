<?php

namespace DigicoSimulation\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $primaryKey = 'label';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'label',
        'cell_reference'
    ];
}

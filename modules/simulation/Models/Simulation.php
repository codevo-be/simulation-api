<?php

namespace DigicoSimulation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Simulation extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'contact_id' => null,
        'status' => 'draft',
    ];

    protected $fillable = [
        'current_step',
        'spreadsheet_id',
        'contact_id'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($simulation)
        {
            if(empty($simulation->id))
            {
                $simulation->id = (string) Str::uuid();
            }
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userTenant extends Model
{
    protected $fillable = ['user_id', 'tenant_id', 'role'];
}

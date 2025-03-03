<?php

namespace Diji\Billing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class NordigenAccount extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'account_expires_at'];

    public static function getValidAccountId()
    {
        $account = self::latest()->first();

        if (!$account || Carbon::now()->gte($account->account_expires_at)) {
            return null;
        }

        return $account->account_id;
    }
}

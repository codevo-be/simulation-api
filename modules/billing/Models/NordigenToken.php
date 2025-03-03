<?php

namespace Diji\Billing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class NordigenToken extends Model
{
    use HasFactory;

    protected $fillable = ['access_token', 'access_expires_at', 'refresh_token', 'refresh_expires_at'];

    public static function getValidToken()
    {
        $token = self::latest()->first();

        if (!$token || Carbon::now()->gte($token->access_expires_at)) {
            return null;
        }

        return $token->access_token;
    }

    public static function saveToken($access, $accessExpiresIn, $refresh, $refreshExpiresIn)
    {
        return self::create([
            'access_token' => $access,
            'access_expires_at' => Carbon::now()->addSeconds($accessExpiresIn),
            'refresh_token' => $refresh,
            'refresh_expires_at' => Carbon::now()->addSeconds($refreshExpiresIn),
        ]);
    }
}

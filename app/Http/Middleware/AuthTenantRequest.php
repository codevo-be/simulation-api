<?php

namespace App\Http\Middleware;

use App\Models\UserTenant;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthTenantRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $tenant_id = $request->header('X-Tenant');
        $authorization = $request->header('Authorization');

        if (!$tenant_id) {
            return response()->json([
                'message' => 'The headers need X-Tenant !'
            ], 400);
        }

        if (!$authorization) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $jwtToken = str_replace('Bearer ', '', $authorization);

        try {
            $publicKey = file_get_contents(storage_path('oauth-public.key'));
            $decoded = JWT::decode($jwtToken, new Key($publicKey, 'RS256'));


            if (!isset($decoded->sub)) {
                return response()->json(['message' => 'Invalid token payload'], 401);
            }

            $userId = $decoded->sub;

            $user = Auth::guard('api')->getProvider()->retrieveById($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $relation_exist = UserTenant::where('user_id', $user->id)
                ->where('tenant_id', $tenant_id)
                ->exists();

            if (!$relation_exist) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            Auth::setUser($user);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid or expired token', 'error' => $e->getMessage()], 401);
        }
    }
}

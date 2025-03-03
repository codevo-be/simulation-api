<?php

namespace App\Http\Middleware;

use App\Models\UserTenant;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedById;

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

        if (!$tenant_id) {
            return response()->json([
                'message' => 'The headers need X-Tenant !'
            ], 400);
        }

        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $relation_exist = UserTenant::where('user_id', $user->id)
                ->where('tenant_id', $tenant_id)
                ->exists();

            if (!$relation_exist) {
                return response()->json(['message' => 'Not authorized to Tenant'], 403);
            }

            try {
                tenancy()->initialize($tenant_id);
            } catch (TenantCouldNotBeIdentifiedById $e) {
                return response()->json(['message' => 'Tenant not found'], 403);
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid or expired token', 'error' => $e->getMessage()], 401);
        }
    }
}

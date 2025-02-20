<?php

namespace App\Http\Middleware;

use App\Models\UserTenant;
use Closure;
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
        $user_id = Auth::id();
        $tenant_id = $request->header('X-Tenant');

        if (!$tenant_id) {
            return response()->json([
                'message' => 'The headers need X-Tenant !'
            ], 400);
        }

        if(!$user_id){
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $relation_exist = UserTenant::where('user_id', $user_id)->where('tenant_id', $tenant_id)->exists();

        if(!$relation_exist){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}

<?php

namespace Diji\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Diji\Billing\Models\NordigenAccount;
use Diji\Billing\Services\NordigenService;

class NordigenController extends \App\Http\Controllers\Controller
{
    public function institutions(): \Illuminate\Http\JsonResponse
    {
        $nordigenService = new NordigenService();

        return response()->json([
            'data' => $nordigenService->getInstitutions()
        ]);
    }

    public function handleCallback(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $ref = $request->query('ref');
        $tenant_id = $request->query('tenant_id');

        if (!$ref) {
            return response()->json(['error' => 'La référence est manquante !'], 400);
        }

        if (!$tenant_id) {
            return response()->json(['error' => 'Le tenant est manquant !'], 400);
        }

        tenancy()->initialize($tenant_id);

        $nordigenService = new NordigenService();

        $data = $nordigenService->getRequisitionByReference($ref);

        NordigenAccount::create([
            "account_id" => $data["accounts"][0],
            "account_expires_at" => Carbon::now()->addDays(90),
        ]);

        return redirect()->to(env('FRONTEND_URLS'));
    }
}

<?php

namespace Diji\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Diji\Billing\Http\Requests\StoreBillingItemRequest;
use Diji\Billing\Http\Requests\UpdateBillingItemRequest;
use Diji\Billing\Resources\BillingItemResource;
use Diji\Billing\Models\BillingItem;
use Illuminate\Http\Request;

class BillingItemController extends Controller
{
    public function index(Request $request)
    {
        $parent = BillingItem::findParent($request);

        return BillingItemResource::collection($parent->items)->response();
    }

    public function store(StoreBillingItemRequest $request)
    {
        $data = $request->all();

        $parent = BillingItem::findParent($request);

        $item = $parent->items()->create($data);

        return response()->json([
            'data' => new BillingItemResource($item),
        ], 201);
    }

    public function update(UpdateBillingItemRequest $request, int $model_id, int $id)
    {
        $data = $request->validated();

        $item = BillingItem::find($id);

        $item->update($data);

        return response()->json([
            'data' => new BillingItemResource($item)
        ]);
    }

    public function destroy(int $model_id, int $id)
    {
        $item = BillingItem::find($id);

        $item->delete();

        return response()->noContent();
    }
}

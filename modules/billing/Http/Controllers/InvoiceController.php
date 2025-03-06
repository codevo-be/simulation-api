<?php

namespace Diji\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Diji\Billing\Http\Requests\StoreInvoiceRequest;
use Diji\Billing\Http\Requests\UpdateInvoiceRequest;
use Diji\Billing\Resources\InvoiceResource;
use Diji\Billing\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stancl\Tenancy\Tenancy;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::query();

        if($request->filled('contact_id')){
            $query->where("contact_id", $request->contact_id);
        }

        if($request->filled('status')){
            $query->where("status", $request->status);
        }

        return InvoiceResource::collection($query->get())->response();
    }

    public function show(int $invoice_id): \Illuminate\Http\JsonResponse
    {
        $invoice = Invoice::findOrFail($invoice_id);

        return response()->json([
            'data' => new InvoiceResource($invoice)
        ]);
    }

    public function store(StoreInvoiceRequest $request)
    {
        $data = $request->validated();

        $invoice = Invoice::create($data);

        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $item) {
                $invoice->items()->create($item);
            }
            $invoice->load('items');
        }


        return response()->json([
            'data' => new InvoiceResource($invoice),
        ], 201);
    }

    public function update(UpdateInvoiceRequest $request, int $invoice_id): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $invoice = Invoice::findOrFail($invoice_id);

        $invoice->update($data);

        return response()->json([
            'data' => new InvoiceResource($invoice),
        ]);
    }

    public function destroy(int $invoice_id): \Illuminate\Http\Response
    {
        $invoice = Invoice::findOrFail($invoice_id);

        $invoice->delete();

        return response()->noContent();
    }

    public function batchDestroy(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'invoice_ids' => 'required|array',
            'invoice_ids.*' => 'integer|exists:invoices,id',
        ]);

        $invoices = Invoice::whereIn('id', $request->invoice_ids)->get();

        foreach ($invoices as $invoice) {
            try{
                $invoice->delete();
            }catch (\Exception $e){
                continue;
            }
        }

        return response()->noContent();
    }

    public function pdf(Request $request, int $invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id)->load('items');

        $pdf = PDF::loadView('billing::invoice', $invoice->toArray());

        return $pdf->stream("invoice-$invoice->identifier_number.pdf");
    }

    public function email(Request $request, int $invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id)->load('items');

        $pdf = PDF::loadView('billing::invoice', $invoice->toArray());

        try {
            Mail::send('billing::email', ["body" => $request->body], function ($message) use($request, $pdf) {
                $tenant = tenant();
                $message->from([env('MAIL_FROM_ADDRESS'), $tenant->name]);
                $message->to($request->to);

                if($request->subject){
                    $message->subject($request->subject);
                }

                if($request->cc){
                    $message->cc($request->cc);
                }

                $message->attachData($pdf->output(), "aa.pdf", [
                    "mime" => 'application/pdf'
                ]);
            });
        }catch (\Exception $e){
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }


        return response()->noContent();
    }
}

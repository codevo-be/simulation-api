<?php

namespace Diji\Billing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'sometimes', // todo enum
            'invoice_id' => 'sometimes|exists:invoices,id',
            'issuer' => 'sometimes|array',
            'issuer.name' => 'required_with:issuer|string',
            'issuer.street' => 'required_with:issuer|string',
            'issuer.street_number' => 'required_with:issuer|string',
            'issuer.city' => 'required_with:issuer|string',
            'issuer.zipcode' => 'required_with:issuer|string',
            'issuer.country' => 'required_with:issuer|string',
            'issuer.vat_number' => 'sometimes|string',
            'issuer.iban' => 'required_with:issuer|string',
            'date' => 'sometimes|date',
            'subtotal' => 'nullable|numeric',
            'taxes' => 'nullable|array',
            "taxes.*" => 'numeric',
            'total' => 'nullable|numeric',
            'contact_name' => 'nullable|string',
            'vat_number' => 'nullable|string|max:12',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:150',
            'street' => 'nullable|string',
            'street_number' => 'nullable|string|max:100',
            'city' => 'nullable|string',
            'zipcode' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:2',
            'contact_id' => 'nullable|exists:contacts,id',
            'items' => 'sometimes|nullable|array',
            'items.*.' => (new StoreBillingItemRequest())->rules()
        ];
    }
}

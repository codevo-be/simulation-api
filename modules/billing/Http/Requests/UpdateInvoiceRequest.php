<?php

namespace Diji\Billing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to false if only authorized users can update suppliers
    }

    public function rules(): array
    {
        return [
            'status' => 'sometimes', // todo enum
            'issuer' => 'sometimes|array',
            'issuer.name' => 'required_with:issuer|string',
            'issuer.address' => 'required_with:issuer|string',
            'issuer.vat_number' => 'sometimes|string',
            'issuer.iban' => 'required_with:issuer|string',
            'date' => 'sometimes|date',
            'due_date' => 'sometimes|nullable|date',
            'payment_date' => 'sometimes|nullable|date',
            'subtotal' => 'sometimes|nullable|numeric',
            'taxes' => 'sometimes|nullable|array',
            'total' => 'sometimes|nullable|numeric',
            'contact_name' => 'sometimes|nullable|string',
            'vat_number' => 'sometimes|nullable|string|max:12',
            'email' => 'sometimes|nullable|email|max:150',
            'phone' => 'sometimes|nullable|string|max:150',
            'street' => 'sometimes|nullable|string',
            'street_number' => 'sometimes|nullable|string|max:100',
            'city' => 'sometimes|nullable|string',
            'zipcode' => 'sometimes|nullable|string|max:50',
            'country' => 'sometimes|nullable|string|max:2',
            'items' => 'sometimes|nullable|array',
            'items.*.' => (new UpdateBillingItemRequest())->rules()
        ];
    }
}

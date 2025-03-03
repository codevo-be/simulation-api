<?php

namespace Diji\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'nullable|string|required_without_all:vat_number,',
            'lastname' => 'nullable|string|required_without_all:vat_number,',
            'email' => 'nullable|email|max:150|unique:contacts,email',
            'phone' => 'nullable|string|max:150',
            'company_name' => 'nullable|string|required_with:vat_number',
            'vat_number' => 'nullable|string|max:12',
        ];
    }
}

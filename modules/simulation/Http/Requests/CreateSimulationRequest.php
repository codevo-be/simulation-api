<?php

namespace DigicoSimulation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSimulationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_step' => 'required|string|max:100',
        ];
    }
}

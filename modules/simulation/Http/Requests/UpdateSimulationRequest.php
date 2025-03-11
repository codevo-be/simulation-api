<?php

namespace DigicoSimulation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSimulationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_step' => 'required|string|max:100',
            'label' => 'required|string|max:100',
            'response' => 'nullable|string|max:255', //TODO à changer nullable ?
        ];
    }
}

<?php

namespace DigicoSimulation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateSimulationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'simulation_id' => 'required|string|exists:simulations,id',
            'email'=> 'required|string|email|max:255',
            'phone'=> 'required|string|max:255',
            'zip_code'=> 'required|string|max:255',
        ];
    }
}

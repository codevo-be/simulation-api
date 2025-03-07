<?php

namespace DigicoSimulation\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessfulCreationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'message' => 'Simulation created successfully',
            'data' => $this->resource,
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success',
            'code' => 201,
        ];
    }
}

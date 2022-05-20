<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'dni' => $this->dni,
            'nombre' => $this->name,
            'apellidos' => $this->last_name,
            'email' => $this->email,
            'Fecha de registro' => $this->date_reg,
            'status' => $this->status
        ];
    }
}

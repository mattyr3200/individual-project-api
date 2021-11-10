<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TriggerResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "wire" => $this->wire,
            "trigger_voltage" => $this->trigger_voltage,
            "device" => $this->device,
        ];
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TriggerLogResource extends JsonResource
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
            'log_id' => $this->id,
            'name' => $this->trigger->name,
            'description' => $this->trigger->description,
            'wire' => $this->trigger->wire,
            'trigger_voltage' => $this->trigger->trigger_voltage,
            'trigger_time' => Carbon::parse($this->created_at)->toDateTimeString()
        ];
    }
}

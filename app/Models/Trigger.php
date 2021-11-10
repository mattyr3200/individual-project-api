<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trigger extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'trigger_voltage' => 'boolean',
    ];


    public function device () : HasOne
    {
        return $this->hasOne(Device::class, "id", "device_id");
    }
}

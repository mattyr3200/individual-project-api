<?php

namespace App\Models;

use App\Traits\UUID;
use App\Models\Device;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trigger extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'trigger_voltage' => 'boolean',
    ];

    public function device(): HasOne
    {
        return $this->hasOne(Device::class, 'id', 'device_id');
    }

    public function triggerLogs(): HasMany
    {
        return $this->hasMany(TriggerLog::class, 'trigger_id', 'id');
    }
}

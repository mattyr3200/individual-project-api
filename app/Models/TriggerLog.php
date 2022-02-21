<?php

namespace App\Models;

use App\Traits\UUID;
use App\Models\Trigger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TriggerLog extends Model
{
    use HasFactory, UUID;

    protected $guarded = [];

    public function trigger(): HasOne
    {
        return $this->hasOne(Trigger::class, 'id', 'trigger_id');
    }
}

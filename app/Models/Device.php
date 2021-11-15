<?php

namespace App\Models;

use App\Traits\UUID;
use App\Models\Trigger;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory, UUID, SoftDeletes, HasApiTokens;

    protected $guarded = [];


    public function triggers () : HasMany {
        return $this->hasMany(Trigger::class, 'device_id', 'id');
    }
}

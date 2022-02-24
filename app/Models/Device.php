<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Device extends Model
{
    use HasFactory, UUID, SoftDeletes, HasApiTokens;

    protected $guarded = [];
    protected $casts = [
        'is_armed' => "boolean"
    ];

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class, 'device_id', 'id');
    }
}

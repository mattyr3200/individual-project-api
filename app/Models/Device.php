<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UUID;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}

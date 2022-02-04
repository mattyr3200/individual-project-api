<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriggerLog extends Model
{
    use HasFactory, UUID;

    protected $guarded = [];
}

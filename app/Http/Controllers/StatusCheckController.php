<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;

class StatusCheckController extends Controller
{
    public function __invoke()
    {
        return new StatusResource([
            "time" => now()->toDateTimeString(),
            "signed_in" => auth()->user() ? true : false,
        ]);
    }
}

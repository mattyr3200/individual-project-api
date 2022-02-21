<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\StatusResource;


class StatusCheckController extends Controller
{
    public function __invoke(Request $request)
    {
        return new StatusResource([
            'time' => now()->toDateTimeString(),
            'signed_in' => auth()->user() ? true : false,
        ]);
    }
}

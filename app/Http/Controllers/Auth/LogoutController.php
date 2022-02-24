<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response("Logged out", 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        return new UserResource($user);
    }
}

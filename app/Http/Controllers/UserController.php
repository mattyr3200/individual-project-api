<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        return new UserResource ([
            "name" => $user->name,
            "email" => $user->email,
            "id" => $user->id,
        ]);
    }
}

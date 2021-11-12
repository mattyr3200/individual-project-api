<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create(
            array_merge(
                $request->except(['password']),
                ['password' => Hash::make($request->get('password'))]
            )
        );

        return new TokenResource([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }
}

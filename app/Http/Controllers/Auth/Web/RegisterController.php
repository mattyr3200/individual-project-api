<?php

namespace App\Http\Controllers\Auth\Web;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\TokenResource;
use App\Http\Requests\Auth\RegisterRequest;

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
            'token' => $user->createToken("API Token")->plainTextToken
        ]);
    }
}

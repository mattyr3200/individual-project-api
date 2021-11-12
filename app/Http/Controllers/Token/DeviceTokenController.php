<?php

namespace App\Http\Controllers\Token;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeviceTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create (Device $device)
    {
        $token = $device->createToken($device->name, ['create:trigger-log']);

        return [
            "token" => $token->plainTextToken
        ];
    }

    public function destroy (Device $device, Request $request) {
        $device->tokens()->where('id', $request->get('token_id'))->delete();

        return response('token deleted', 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceStatusRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Http\Request;

class ChangeDeviceStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Device $device, DeviceStatusRequest $request)
    {
        if ($device->user_id !== auth()->user()->id) {
            abort(422);
        }

        $device->update([
            'is_armed' => $request->is_armed
        ]);

        return new DeviceResource($device);
    }
}

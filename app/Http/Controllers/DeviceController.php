<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Device::class, 'device');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DeviceResource::collection(
            Device::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDeviceRequest $request)
    {
        return new DeviceResource(
            $request->user()->devices()->create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        return new DeviceResource($device);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeviceRequest $request, Device $device)
    {
        $device->update($request->validated());

        return new DeviceResource($device);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        
    }
}

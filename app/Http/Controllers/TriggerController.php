<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTriggerRequest;
use App\Http\Resources\TriggerResource;
use App\Models\Device;
use App\Models\Trigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TriggerController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Trigger::class, 'trigger');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(?Device $device = null)
    {
        if ((string) $device->user_id !== (string) Auth::user()->id) {
            abort(403);
        }

        return TriggerResource::collection(
            Trigger::where('device_id', $device->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTriggerRequest $request)
    {
        return new TriggerResource(Trigger::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trigger  $trigger
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Trigger $trigger)
    {
        return new TriggerResource($trigger);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trigger  $trigger
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trigger $trigger)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trigger  $trigger
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trigger $trigger)
    {
        
    }
}

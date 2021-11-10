<?php

namespace App\Http\Controllers;

use App\Models\Trigger;
use Illuminate\Http\Request;
use App\Http\Resources\TriggerResource;
use App\Http\Requests\CreateTriggerRequest;

class TriggerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TriggerResource::collection(Trigger::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trigger $trigger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trigger  $trigger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trigger $trigger)
    {
        //
    }
}
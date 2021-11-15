<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\TriggerLog;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTriggerLogRequest;

class TriggerLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTriggerLogRequest $request)
    {
        $deviceTriggerId = Device::find($request->user()->currentAccessToken()->tokenable->id)
            ->triggers()
            ->where('wire', $request->wire)
            ->where('trigger_voltage', $request->voltage)
            ->first();

        return $deviceTriggerId ? TriggerLog::create([
            'trigger_id' => $deviceTriggerId
        ]) : response('No Trigger Set Up');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

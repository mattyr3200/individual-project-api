<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTriggerLogRequest;
use App\Http\Resources\TriggerLogResource;
use App\Models\Device;
use App\Models\TriggerLog;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class TriggerLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Device $device)
    {
        if ($device->user_id === auth()->user()->id) {
            return abort(401, "Unauthorized");
        }

        return TriggerLogResource::collection($device->triggers()
            ->with('triggerLogs')
            ->get()
            ->pluck('triggerLogs')[0]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTriggerLogRequest $request)
    {
        $deviceTriggers = Device::find($request->user()->currentAccessToken()->tokenable->id)
            ->triggers()
            ->where('wire', $request->wire)
            ->where('trigger_voltage', $request->voltage)
            ->get();

        if ($deviceTriggers) {
            foreach ($deviceTriggers as $trigger) {
                TriggerLog::create([
                    'trigger_id' => $trigger->id,
                ]);
            }
        }

        return (count($deviceTriggers) >= 1) ? response ("Trigger Logged", 201)  : response('No Trigger Set Up');
    }
}

<?php

namespace App\Http\Controllers\TriggerSummary;

use Carbon\Carbon;
use App\Models\Device;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class YearlyDeviceTriggers extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Device $device)
    {
        $period = CarbonPeriod::create(now()->subYear()->addDay()->format('Y-m-d'), now()->format('Y-m-d'))->toArray();

        $days = [];

        foreach($period as $periodDay) {
            $formattedDate = $periodDay->format('Y-m-d');

            $days[$formattedDate] = [$formattedDate, 0];
        }

        $weeklyTriggerTotals = $device->triggers()
            ->join('trigger_logs', function ($join) {
                $join->on('trigger_logs.trigger_id', '=', 'triggers.id')
                    ->where('trigger_logs.created_at',">=", now()->subWeek());
            })
            ->groupBy(DB::raw('Date(trigger_logs.created_at)'))
            ->select(DB::raw('Date(trigger_logs.created_at) as date'), DB::raw('count(*) as total'))
            ->orderBy(DB::raw('Date(trigger_logs.created_at)'))
            ->get();

        foreach ($weeklyTriggerTotals as $triggerTotal) {
            $days[$triggerTotal->date] = [$triggerTotal->date, $triggerTotal->total];
        }

        return array_values($days);
    }
}

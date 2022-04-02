<?php

namespace App\Observers;

use App\Models\TriggerLog;
use App\Notifications\TriggerLogCreatedNotification;

class TriggerLogObserver
{
    /**
     * Handle the TriggerLog "created" event.
     *
     * @param  \App\Models\TriggerLog  $triggerLog
     * @return void
     */
    public function created(TriggerLog $triggerLog)
    {
        $triggerLog->trigger->device->user->notify(new TriggerLogCreatedNotification($triggerLog));
    }

    /**
     * Handle the TriggerLog "updated" event.
     *
     * @param  \App\Models\TriggerLog  $triggerLog
     * @return void
     */
    public function updated(TriggerLog $triggerLog)
    {
        //
    }

    /**
     * Handle the TriggerLog "deleted" event.
     *
     * @param  \App\Models\TriggerLog  $triggerLog
     * @return void
     */
    public function deleted(TriggerLog $triggerLog)
    {
        //
    }

    /**
     * Handle the TriggerLog "restored" event.
     *
     * @param  \App\Models\TriggerLog  $triggerLog
     * @return void
     */
    public function restored(TriggerLog $triggerLog)
    {
        //
    }

    /**
     * Handle the TriggerLog "force deleted" event.
     *
     * @param  \App\Models\TriggerLog  $triggerLog
     * @return void
     */
    public function forceDeleted(TriggerLog $triggerLog)
    {
        //
    }
}

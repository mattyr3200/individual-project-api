<?php

namespace App\Policies;

use App\Models\Trigger;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TriggerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trigger  $trigger
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Trigger $trigger)
    {
        return (string) $user->id === (string) $trigger->device->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trigger  $trigger
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Trigger $trigger)
    {
        return (string) $user->id === (string) $trigger->device->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trigger  $trigger
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Trigger $trigger)
    {
        return (string) $user->id === (string) $trigger->device->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trigger  $trigger
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Trigger $trigger)
    {
        return (string) $user->id === (string) $trigger->device->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trigger  $trigger
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Trigger $trigger)
    {
        return (string) $user->id === (string) $trigger->device->user_id;
    }
}

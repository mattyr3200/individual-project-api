<?php

namespace App\Providers;

use App\Models\Device;
use App\Models\Trigger;
use App\Policies\DevicePolicy;
use App\Policies\TriggerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Device::class => DevicePolicy::class,
        Trigger::class => TriggerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    
    }
}

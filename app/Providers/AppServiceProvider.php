<?php

namespace App\Providers;

use App\Models\TriggerLog;
use App\Observers\TriggerLogObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        TriggerLog::observe(TriggerLogObserver::class);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Sms;
use App\Observers\SmsObserver;

/**
 * @author
 *
 * 观察者服务提供者
 *
 */
class ModelObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Sms::observe(SmsObserver::class);
    }

    public function register()
    {
        # code...
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\permChangeEvent' => [
            'App\Listeners\permChangeListener',
        ],
        'App\Events\userActionEvent' => [
            'App\Listeners\userActionListener',
        ],
        'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'SocialiteProviders\QQ\QqExtendSocialite@handle',
            'SocialiteProviders\Weixin\WeixinExtendSocialite@handle',
            'SocialiteProviders\Weibo\WeiboExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

<?php

namespace Inventas\ContactSupport\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Inventas\ContactSupport\Events\SupportCaseCreated;
use Inventas\ContactSupport\Listeners\SupportCaseCreatedNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SupportCaseCreated::class => [
            SupportCaseCreatedNotification::class,
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
    }
}

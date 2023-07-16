<?php

namespace Inventas\ContactSupport\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Inventas\ContactSupport\Events\SupportCaseCreated;

class SupportCaseCreatedNotification implements ShouldQueue
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        // ...
    }

    /**
     * Handle the event.
     */
    public function handle(SupportCaseCreated $event): void
    {



//        $event->supportCase
    }

    /**
     * Determine whether the listener should be queued.
     */
    public function shouldQueue(SupportCaseCreated $event): bool
    {
        return config('contact-support.should_queue_mails');
    }

}

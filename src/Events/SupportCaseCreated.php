<?php

namespace Inventas\ContactSupport\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Inventas\ContactSupport\Models\SupportCase;

class SupportCaseCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public SupportCase $supportCase,
    ) {
    }
}

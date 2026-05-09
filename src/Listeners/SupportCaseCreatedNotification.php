<?php

namespace Inventas\ContactSupport\Listeners;

use Illuminate\Support\Facades\Mail;
use Inventas\ContactSupport\Events\SupportCaseCreated;
use Inventas\ContactSupport\Mailable\RawMailable;
use Inventas\ContactSupport\SupportCaseTypeResolver;

class SupportCaseCreatedNotification
{
    /**
     * Handle the event.
     */
    public function handle(SupportCaseCreated $event): void
    {
        $supportCase = $event->supportCase->refresh();
        $config = SupportCaseTypeResolver::type($supportCase->type);
        $receivers = $config['receiver'];

        $mailable = (new RawMailable(
            content: $supportCase->getRawContent()
        ))
            ->subject($supportCase->getSubject())
            ->replyTo($supportCase->getReplyTo(), $supportCase->name)
            ->from(config('contact-support.from_address'), config('contact-support.from_name'));

        if (config('contact-support.should_queue_mails')) {
            Mail::to($receivers)->queue($mailable);
        } else {
            Mail::to($receivers)->send($mailable);
        }
    }
}

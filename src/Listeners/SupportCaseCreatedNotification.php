<?php

namespace Inventas\ContactSupport\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Inventas\ContactSupport\Events\SupportCaseCreated;
use Inventas\ContactSupport\Mailable\RawMailable;
use Inventas\ContactSupport\SupportCaseTypeResolver;

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
        $config = SupportCaseTypeResolver::type($event->supportCase->type);
        $supportCase = $event->supportCase;
        $receivers = $config['receiver'];

        $mailable = (new RawMailable(
            content: $supportCase->getRawContent()
        ))
            ->subject($supportCase->getSubject())
            ->to($receivers)
            ->replyTo($supportCase->getReplyTo(), $supportCase->name)
            ->from(config('contact-support.from_address'), config('contact-support.from_name'));

        if (config('contact-support.should_queue_mails')) {
            Mail::to($receivers)->queue($mailable);
        } else {
            Mail::to($receivers)->send($mailable);
        }

//        Mail::raw($event->supportCase->getRawContent(), function (Message $message) use ($config, $supportCase) {
//            $message->from("hello@24doors.app", "24doors Support System");
//            $message->to($config['receiver']);
//            $message->subject($supportCase->getSubject());
//            $message->replyTo($supportCase->getReplyTo());
//        });

    }

    /**
     * Determine whether the listener should be queued.
     */
    public function shouldQueue(SupportCaseCreated $event): bool
    {
        return config('contact-support.should_queue_mails');
    }

}

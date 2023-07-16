<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Inventas\ContactSupport\Events\SupportCaseCreated;
use Inventas\ContactSupport\Mailable\RawMailable;
use Inventas\ContactSupport\Models\SupportCase;

test('creation triggers SupportCaseCreated event', function () {

    $mail = Mail::fake();
    Queue::fake();
    Mail::assertNothingSent();
    Mail::assertNothingQueued();

    $supportCase = SupportCase::create([
        'name' => 'Lennart Fischer',
        'email' => 'lennart.fischer@example.org',
    ]);

    $supportCase = $supportCase->refresh();

    Mail::assertQueued(RawMailable::class);

});

test('quiet creation does not trigger event', function () {

    Event::fake();
    Mail::fake();
    Queue::fake();

    $supportCaseSilent = SupportCase::make([
        'name' => 'Lennart Fischer',
        'email' => 'lennart.fischer@example.org',
    ])->saveQuietly();

    Event::assertNotDispatched(SupportCaseCreated::class);

    Mail::assertNothingQueued();

});

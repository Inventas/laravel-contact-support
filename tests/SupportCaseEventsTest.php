<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Inventas\ContactSupport\Events\SupportCaseCreated;
use Inventas\ContactSupport\Mailable\RawMailable;
use Inventas\ContactSupport\Models\SupportCase;

test('creation triggers SupportCaseCreated event', function () {

    Event::fake();
    Mail::fake();
    Mail::assertNothingSent();
    Mail::assertNothingQueued();

    $supportCase = SupportCase::create([
        'name' => 'Lennart Fischer',
        'email' => 'lennart.fischer@example.org',
    ]);

    Event::assertDispatched(SupportCaseCreated::class);

    //    Mail::assertSent(RawMailable::class);
    //    Mail::assertSent(RawMailable::class);

});

test('quiet creation does not trigger event', function () {

    Event::fake();

    $supportCaseSilent = SupportCase::make([
        'name' => 'Lennart Fischer',
        'email' => 'lennart.fischer@example.org',
    ])->saveQuietly();

    Event::assertNotDispatched(SupportCaseCreated::class);

    Mail::assertNothingQueued();

});

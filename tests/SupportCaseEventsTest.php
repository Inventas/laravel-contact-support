<?php

use Illuminate\Support\Facades\Event;
use Inventas\ContactSupport\Events\SupportCaseCreated;
use Inventas\ContactSupport\Models\SupportCase;

test('creation triggers SupportCaseCreated event', function () {

    Event::fake();

    $supportCase = SupportCase::create([
        'name' => 'Lennart Fischer',
        'email' => 'lennart.fischer@example.org',
    ]);

    Event::assertDispatched(SupportCaseCreated::class);

});

test('quiet creation does not trigger event', function () {

    Event::fake();

    $supportCaseSilent = SupportCase::make([
        'name' => 'Lennart Fischer',
        'email' => 'lennart.fischer@example.org',
    ])->saveQuietly();

    Event::assertNotDispatched(SupportCaseCreated::class);

});

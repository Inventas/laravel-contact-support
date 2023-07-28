<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Inventas\ContactSupport\Models\SupportCase;

it('can be created', function () {

    Mail::fake();
    Event::fake();
    Queue::fake();

    $supportCase = SupportCase::create([
        'name' => 'John Doe',
        'email' => 'john.doe@example.org',
    ]);

    expect($supportCase->name)->toBe('John Doe')
        ->and($supportCase->email)->toBe('john.doe@example.org');

});

it('can be created with factory', function () {

    Mail::fake();
    Event::fake();
    Queue::fake();

    $supportCase = SupportCase::factory()->create();

    expect($supportCase)->name->not->toBeNull()
        ->and($supportCase->email)->not->toBeNull();

});

it('can have extra properties', function () {

    Mail::fake();
    Event::fake();
    Queue::fake();

    $supportCase = SupportCase::create([
        'name' => 'John Doe',
        'email' => 'john.doe@example.org',
        'phone' => '12345678',
        'extras' => [
            'number_of_customers' => 1000,
        ],
    ]);

    expect($supportCase->extras['number_of_customers'])->toBe(1000);

});

it('can be scoped to open support cases', function () {

    Mail::fake();
    Event::fake();
    Queue::fake();

    $openCases = SupportCase::factory()->open()->count(2)->create();
    $closedCases = SupportCase::factory()->closed()->count(3)->create();

    expect(SupportCase::open()->count())->toBe(2)
        ->and(SupportCase::closed()->count())->toBe(3);

});

it('returns the correct subject', function () {

    Mail::fake();
    Event::fake();
    Queue::fake();

    $supportCase = SupportCase::factory()->create([
        'type' => 'default',
        'name' => 'John Doe',
    ]);

    expect($supportCase->getSubject())->toBe('(#1) Support case:  John Doe');

});

it('returns the correct content', function () {

    Mail::fake();
    Event::fake();
    Queue::fake();

    $supportCase = SupportCase::factory()->create([
        'type' => 'default',
        'name' => 'John Doe',
        'email' => 'john.doe@example.org',
    ]);

    $content = $supportCase->getRawContent();

    $expected = <<<'EOT'
ID: #1
Channel: Default
Name: John Doe
Email: john.doe@example.org
EOT;

    expect($content)->toBe($expected);

});

it('returns the correct content (sales)', function () {

    Mail::fake();
    Event::fake();
    Queue::fake();

    $supportCase = SupportCase::factory()->create([
        'type' => 'sales',
        'name' => 'John Doe',
        'email' => 'john.doe@example.org',
        'extras' => [
            'company' => 'Inventas GmbH',
            'number_of_customers' => 1000,
        ],
        'message' => "Hello world\nThis is some multiline text",
    ]);

    $content = $supportCase->getRawContent();

    $expected = <<<'EOT'
ID: #1
Channel: Sales
Name: John Doe
Email: john.doe@example.org
Company: Inventas GmbH
Number of customers: 1000


Hello world
This is some multiline text
EOT;

    expect($content)->toBe($expected);

});

it('returns the correct content (app)', function () {

    Mail::fake();
    Event::fake();
    Queue::fake();

    $supportCase = SupportCase::factory()->create([
        'type' => 'default',
        'name' => 'John Doe',
        'email' => 'john.doe@example.org',
        'extras' => [
            'manufacturer' => 'Apple',
            'model' => 'iPhone 14 Pro',
        ],
        'message' => "Hello world\nThis is some multiline text",
    ]);

    $content = $supportCase->getRawContent();

    $expected = <<<'EOT'
ID: #1
Channel: Default
Name: John Doe
Email: john.doe@example.org
Manufacturer: Apple
Model: iPhone 14 Pro


Hello world
This is some multiline text
EOT;

    expect($content)->toBe($expected);

});

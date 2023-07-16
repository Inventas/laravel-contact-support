<?php

use Inventas\ContactSupport\Models\SupportCase;

it('can be created', function () {

    $supportCase = SupportCase::create([
        'name' => 'John Doe',
        'email' => 'john.doe@example.org',
    ]);

    expect($supportCase->name)->toBe('John Doe')
        ->and($supportCase->email)->toBe('john.doe@example.org');

});

it('can be created with factory', function () {

    $supportCase = SupportCase::factory()->create();

    expect($supportCase)->name->not->toBeNull()
        ->and($supportCase->email)->not->toBeNull();

});

it('can have extra properties', function () {

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

    $openCases = SupportCase::factory()->open()->count(2)->create();
    $closedCases = SupportCase::factory()->closed()->count(3)->create();

    expect(SupportCase::open()->count())->toBe(2)
        ->and(SupportCase::closed()->count())->toBe(3);

});

it('returns the correct subject', function () {

    $supportCase = SupportCase::factory()->create([
        'type' => 'default',
        'name' => 'John Doe',
    ]);

    expect($supportCase->getSubject())->toBe('(#1) Support case:  John Doe');

});

it('returns the correct content', function () {

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

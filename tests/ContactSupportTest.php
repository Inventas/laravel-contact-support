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

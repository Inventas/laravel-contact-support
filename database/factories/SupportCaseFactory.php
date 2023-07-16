<?php

namespace Inventas\ContactSupport\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inventas\ContactSupport\Models\SupportCase;

class SupportCaseFactory extends Factory
{
    protected $model = SupportCase::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'email' => $this->faker->safeEmail(),
        ];
    }

    public function open()
    {
        return $this->state(function (array $attributes) {
            return [
                'closed_at' => null,
            ];
        });
    }

    public function closed()
    {
        return $this->state(function (array $attributes) {
            return [
                'closed_at' => $this->faker->dateTime(),
            ];
        });
    }
}

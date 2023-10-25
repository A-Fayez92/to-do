<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ar_faker = \Faker\Factory::create('ar_EG');
        return [
            'title' => [
                'en' => $this->faker->sentence,
                'ar' => $ar_faker->realText(40),
            ],
            'completed_at' => $this->faker->randomElement([now(), null]),
        ];
    }
}

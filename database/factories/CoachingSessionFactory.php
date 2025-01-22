<?php

namespace Database\Factories;

use App\Enums\CoachingSessionStatus;
use App\Models\Client;
use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CoachingSession>
 */
class CoachingSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('+1 day', '+6 months'),
            'status' => fake()->randomElement([CoachingSessionStatus::Scheduled->value, CoachingSessionStatus::Completed->value]),
            'client_id' => Client::factory(),
            'coach_id' => Coach::factory(),
        ];
    }
}

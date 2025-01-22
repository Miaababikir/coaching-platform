<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => "John " . time(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'coach_id' => Coach::factory(),
        ];
    }
}

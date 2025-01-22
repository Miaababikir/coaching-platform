<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Coach;
use App\Models\CoachingSession;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $batchSize = 10_000;

        for ($i = 0; $i < 1_000_000; $i += $batchSize) {

            $coaches = Coach::factory($batchSize)->create();

            foreach ($coaches as $coach) {

                $clients = Client::factory(1_000)->create();

                $clientIds = $clients->pluck('id');
                $coach->clients()->attach($clientIds);

                foreach ($clients as $client) {
                    $sessions = [];

                    for ($j = 0; $j < 20; $j++) {
                        $sessions[] = [
                            'coach_id' => $coach->id,
                            'client_id' => $client->id,
                            'date' => fake()->dateTimeBetween('+1 days', '+1 year'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    CoachingSession::insert($sessions);

                }

            }
        }

    }
}

<?php

namespace Database\Seeders;

use App\Enums\CoachingSessionStatus;
use App\Models\Client;
use App\Models\Coach;
use App\Models\CoachingSession;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Coach::factory()
            ->count(1000)
            ->make()
            ->each(function ($coaches) {
                DB::table('coaches')->insert($coaches->toArray());

                Coach::query()->chunk(500, function ($coaches) {

                    $coaches->each(function ($coach) {

                        $clients = Client::factory()
                            ->count(1000)
                            ->make([
                                'coach_id' => $coach->id,
                            ]);

                        // Step 2: Batch insert clients

                        DB::table('clients')->insert($clients->toArray());

                        $clientIds = DB::table('clients')->latest('id')->limit(count($clients->toArray()))->pluck('id')->toArray();

                        // Step 3: Prepare sessions in bulk
                        $sessions = [];
                        foreach ($clientIds as $clientId) {
                            for ($i = 0; $i < 20; $i++) {
                                $sessions[] = [
                                    'date' => fake()->dateTimeBetween('+1 day', '+6 months'),
                                    'status' => fake()->randomElement([CoachingSessionStatus::Scheduled->value, CoachingSessionStatus::Completed->value]),
                                    'client_id' => $clientId,
                                    'coach_id' => $coach->id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                            }
                        }

                        DB::table('coaching_sessions')->insert($sessions);
                    });

                }
                );
            });
    }
}

<?php

namespace App\Providers;

use App\Events\ClientCreated;
use App\Events\ClientDeleted;
use App\Events\CoachingSessionCompleted;
use App\Events\CoachingSessionCreated;
use App\Events\CoachingSessionDeleted;
use App\Models\ClientStatistic;
use App\Models\CoachStatistic;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (CoachingSessionCreated $event) {

            $coachStats = CoachStatistic::query()
                ->firstOrCreate(['coach_id' => $event->coachId]);

            $coachStats->update([
                'total_sessions' => $coachStats->total_sessions + 1,
                'scheduled_sessions' => $coachStats->scheduled_sessions + 1,
            ]);

            $clientStats = ClientStatistic::query()
                ->firstOrCreate(['client_id' => $event->clientId, 'coach_id' => $event->coachId]);

            $clientStats->update([
                'total_sessions' => $clientStats->total_sessions + 1,
                'scheduled_sessions' => $clientStats->scheduled_sessions + 1,
            ]);
        });

        Event::listen(function (CoachingSessionCompleted $event) {
            $coachStats = CoachStatistic::query()
                ->firstOrCreate(['coach_id' => $event->coachId]);

            $coachStats->update([
                'completed_sessions' => $coachStats->completed_sessions + 1,
                'scheduled_sessions' => $coachStats->scheduled_sessions - 1,
            ]);

            $clientStats = ClientStatistic::query()
                ->firstOrCreate(['client_id' => $event->clientId, 'coach_id' => $event->coachId]);

            $clientStats->update([
                'completed_sessions' => $clientStats->completed_sessions + 1,
                'scheduled_sessions' => $clientStats->scheduled_sessions - 1,
            ]);
        });

        Event::listen(function (ClientCreated $event) {

            $coachStats = CoachStatistic::query()
                ->firstOrCreate(['coach_id' => $event->coachId]);

            $coachStats->update([
                'total_clients' => $coachStats->total_clients + 1,
            ]);
        });

        Event::listen(function (ClientDeleted $event) {
            $coachStats = CoachStatistic::query()
                ->firstOrCreate(['coach_id' => $event->coachId]);

            $coachStats->update([
                'total_clients' => $coachStats->total_clients - 1,
            ]);
        });
    }
}

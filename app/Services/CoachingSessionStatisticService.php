<?php

namespace App\Services;

use App\Models\ClientStatistic;
use App\Models\CoachStatistic;

class CoachingSessionStatisticService
{

    public function findTotalCoachingSessionConductedByCoachId(int|string $coachId): int
    {
        $stats = CoachStatistic::query()
            ->where("coach_id", $coachId)
            ->first();

        return $stats->total_sessions;
    }

    public function findClientCoachingSessionProgress(int|string $clientId, int|string $coachId): array
    {
        $stats = ClientStatistic::query()
            ->where("client_id", $clientId)
            ->where("coach_id", $coachId)
            ->first();

        return [
            'total' => $stats->total_sessions,
            'scheduled' => $stats->scheduled_sessions,
            'completed' => $stats->completed_sessions,
            'progress' => $stats->total_sessions > 0 ? ($stats->completed_sessions / $stats->total_sessions) * 100 : 0
        ];
    }

}

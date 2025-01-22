<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\CoachingSessionService;
use Illuminate\Http\Request;

class ScheduledCoachingSessions extends Controller
{

    public function __construct(
        protected CoachingSessionService $coachingSessionService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $data = $this->coachingSessionService->findScheduledByClientId(auth()->id());

        return $data;
    }
}

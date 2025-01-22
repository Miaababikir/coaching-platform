<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\CoachingSessionService;
use Illuminate\Http\Request;

class MarkCoachingSessionCompleted extends Controller
{

    public function __construct(
        protected CoachingSessionService $coachingSessionService
    )
    {
    }

    public function __invoke(Request $request, $id)
    {
        $coachingSession = $this->coachingSessionService->markCompleted($id);

        return $coachingSession;

    }
}

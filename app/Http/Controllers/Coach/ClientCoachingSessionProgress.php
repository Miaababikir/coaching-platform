<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Services\CoachingSessionService;
use Illuminate\Http\Request;

class ClientCoachingSessionProgress extends Controller
{

    public function __construct(
        protected CoachingSessionService $coachingSessionService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $data = $this->coachingSessionService->findClientCoachingSessionProgressByCoachId(auth()->id());

        return $data;
    }
}

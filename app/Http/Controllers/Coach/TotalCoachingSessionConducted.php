<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Services\CoachingSessionService;
use Illuminate\Http\Request;

class TotalCoachingSessionConducted extends Controller
{
    public function __construct(
        protected CoachingSessionService $coachingSessionService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $total = $this->coachingSessionService->findTotalCoachingSessionConductedByCoachId(auth()->id());

        return response()->json(['total' => $total]);
    }
}

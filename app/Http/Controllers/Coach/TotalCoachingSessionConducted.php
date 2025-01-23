<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Services\CoachingSessionStatisticService;
use Illuminate\Http\Request;

class TotalCoachingSessionConducted extends Controller
{
    public function __construct(
        protected CoachingSessionStatisticService $coachingSessionStatisticService

    )
    {
    }

    public function __invoke(Request $request)
    {
        $total = $this->coachingSessionStatisticService->findTotalCoachingSessionConductedByCoachId(auth()->id());

        return response()->json(['total' => $total]);
    }
}

<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Services\CoachingSessionStatisticService;
use Illuminate\Http\Request;

class ClientCoachingSessionProgress extends Controller
{

    public function __construct(
        protected CoachingSessionStatisticService $coachingSessionStatisticService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $data = $this->coachingSessionStatisticService->findClientCoachingSessionProgress($request->client_id, auth()->id());

        return $data;
    }
}

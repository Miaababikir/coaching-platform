<?php

namespace App\Http\Controllers\Coach;

use App\Dto\CreateCoachingSessionDto;
use App\Dto\UpdateCoachingSessionDto;
use App\Events\CoachingSessionCreated;
use App\Http\Controllers\Controller;
use App\Services\CoachingSessionService;
use Illuminate\Http\Request;

class CoachingSessionController extends Controller
{
    public function __construct(
        protected CoachingSessionService $coachingSessionService
    )
    {
    }

    public function index(Request $request)
    {
        $data = $this->coachingSessionService->findAllByCoachId(auth()->id());

        return $data;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required'],
            'date' => ['required'],
        ]);

        return $this->coachingSessionService->create(auth()->id(), new CreateCoachingSessionDto(
            clientId: $data['client_id'],
            date: $data['date'],
        ));
    }

    public function show(string $id)
    {
        $session = $this->coachingSessionService->findByIdAndCoachId($id, auth()->id());

        return $session;
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'date' => ['sometimes'],
        ]);

        $session = $this->coachingSessionService->update($id, auth()->id(), new UpdateCoachingSessionDto(
            date: $data['date']?? null,
        ));

        return $session;

    }

    public function destroy(string $id): void
    {
        $this->coachingSessionService->delete($id, auth()->id());
    }
}

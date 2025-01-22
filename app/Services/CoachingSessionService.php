<?php

namespace App\Services;

use App\Dto\CreateCoachingSessionDto;
use App\Dto\UpdateCoachingSessionDto;
use App\Enums\CoachingSessionStatus;
use App\Exceptions\InvalidClientException;
use App\Models\CoachingSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CoachingSessionService
{

    public function __construct(
        protected CoachClientService $coachClientService
    )
    {
    }

    public function findAllByCoachId(int $coachId): LengthAwarePaginator
    {
        $data = CoachingSession::query()
            ->where('coach_id', $coachId)
            ->orderByDesc('created_at')
            ->paginate();

        return $data;
    }

    public function findScheduledByClientId(int|string $clientId): LengthAwarePaginator
    {
        $data = CoachingSession::query()
            ->where('client_id', $clientId)
            ->where('status', CoachingSessionStatus::Scheduled->value)
            ->orderByDesc('created_at')
            ->paginate();

        return $data;
    }

    /**
     * @throws InvalidClientException
     */
    public function create(int $coachId, CreateCoachingSessionDto $param): CoachingSession
    {

        if (!$this->coachClientService->hasCoach($param->clientId, $coachId)) {
            throw new InvalidClientException(__('You are not allowed to create a coaching session for this client'));
        }

        $coachingSession = new CoachingSession();
        $coachingSession->client_id = $param->clientId;
        $coachingSession->date = $param->date;
        $coachingSession->coach_id = $coachId;
        $coachingSession->save();

        return $coachingSession;
    }

    public function findByIdAndCoachId(string $id, int $coachId)
    {
        return CoachingSession::query()
            ->where('id', $id)
            ->where('coach_id', $coachId)
            ->firstOrFail();
    }

    public function update(string $id, int $coachId, UpdateCoachingSessionDto $param)
    {
        $coachingSession = CoachingSession::query()
            ->where('id', $id)
            ->where('coach_id', $coachId)
            ->firstOrFail();

        if ($param->date) {
            $coachingSession->date = $param->date;
        }

        if (!$coachingSession->isDirty()) {
            return $coachingSession;
        }

        $coachingSession->save();

        return $coachingSession;
    }

    public function delete(string $id, int $coachId): void
    {
        $coachingSession = CoachingSession::query()
            ->where('id', $id)
            ->where('coach_id', $coachId)
            ->firstOrFail();

        $coachingSession->delete();
    }

    public function markCompleted($id)
    {
        $coachingSession = CoachingSession::query()
            ->where('id', $id)
            ->firstOrFail();

        $coachingSession->status = CoachingSessionStatus::Completed->value;
        $coachingSession->save();

        return $coachingSession;
    }

    public function findTotalCoachingSessionConductedByCoachId(int|string $coachId): int
    {
        return CoachingSession::query()
            ->where('coach_id', $coachId)
            ->count();
    }

    public function findClientCoachingSessionProgressByCoachId(int|string $coachId)
    {

        $data = CoachingSession::query()
            ->selectRaw('count(*) as total, status')
            ->where('coach_id', $coachId)
            ->groupBy('status')
            ->get();

        return $data;

    }


}

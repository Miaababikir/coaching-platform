<?php

namespace App\Services;

use App\Dto\CreateCoachingSessionDto;
use App\Dto\UpdateCoachingSessionDto;
use App\Enums\CoachingSessionStatus;
use App\Events\CoachingSessionCompleted;
use App\Events\CoachingSessionCreated;
use App\Events\CoachingSessionDeleted;
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

        CoachingSessionCreated::dispatch($coachingSession->id, $coachingSession->client_id, $coachingSession->coach_id);

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

        CoachingSessionDeleted::dispatch($coachingSession->id, $coachingSession->client_id, $coachingSession->coach_id);
    }

    public function markCompleted($id)
    {
        $coachingSession = CoachingSession::query()
            ->where('id', $id)
            ->firstOrFail();

        $coachingSession->status = CoachingSessionStatus::Completed->value;
        $coachingSession->save();

        CoachingSessionCompleted::dispatch($coachingSession->id, $coachingSession->client_id, $coachingSession->coach_id);

        return $coachingSession;
    }
}

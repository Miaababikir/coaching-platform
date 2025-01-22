<?php

namespace App\Services;

use App\Dto\CreateClientDto;
use App\Dto\UpdateClientDto;
use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CoachClientService
{

    public function findAll(int|string $coachId): LengthAwarePaginator
    {
        $query = Client::query();

        $query->where('coach_id', $coachId);

        return $query->paginate();

    }

    public function create(int|string $coachId, CreateClientDto $data): Client
    {

        $client = new Client();
        $client->name = $data->name;
        $client->email = $data->email;
        $client->password = bcrypt($data->password);
        $client->coach_id = $coachId;
        $client->save();

        return $client;
    }

    public function findById(string $id, int|string $couchId)
    {
        $client = Client::query()
            ->where('id', $id)
            ->where('coach_id', $couchId)
            ->firstOrFail();

        return $client;
    }

    public function update(string $id, int|string $couchId, UpdateClientDto $data)
    {
        $client = Client::query()
            ->where('id', $id)
            ->where('coach_id', $couchId)
            ->firstOrFail();

        if ($data->name) {
            $client->name = $data->name;
        }

        if ($data->email) {
            $client->email = $data->email;
        }

        if ($data->password) {
            $client->password = bcrypt($data->password);
        }

        if (!$client->isDirty()) {
            return $client;
        }

        $client->save();

        return $client;
    }

    public function delete(string $id, int|string $couchId): void
    {
        $client = Client::query()
            ->where('id', $id)
            ->where('coach_id', $couchId)
            ->firstOrFail();

        $client->delete();
    }

    public function hasCoach($clientId, $coachId): bool
    {
        return Client::query()
            ->where('id', $clientId)
            ->where('coach_id', $coachId)
            ->exists();

    }
}

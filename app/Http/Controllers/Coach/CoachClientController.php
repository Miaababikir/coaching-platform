<?php

namespace App\Http\Controllers\Coach;

use App\Dto\CreateClientDto;
use App\Dto\UpdateClientDto;
use App\Http\Controllers\Controller;
use App\Services\CoachClientService;
use Illuminate\Http\Request;

class CoachClientController extends Controller
{
    public function __construct(
        protected CoachClientService $clientService
    )
    {
    }

    public function index(Request $request)
    {
        $data = $this->clientService->findAll(auth()->id());

        return $data;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:clients'],
            'password' => ['required', 'min:8'],
        ]);

        return $this->clientService->create(auth()->id(), new CreateClientDto(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        ));

    }

    public function show(string $id)
    {
        return $this->clientService->findById($id, auth()->id());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email'],
            'password' => ['sometimes', 'min:8'],
        ]);

        $client = $this->clientService->update($id, auth()->id(), new UpdateClientDto(
            name: $data['name']?? null,
            email: $data['email']?? null,
            password: $data['password']?? null,
        ));

        return $client;

    }

    public function destroy(string $id)
    {
        $this->clientService->delete($id, auth()->id());
    }
}

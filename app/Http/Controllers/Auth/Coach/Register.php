<?php

namespace App\Http\Controllers\Auth\Coach;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:coaches'],
            'password' => ['required', 'min:8'],
        ]);

        $coach = Coach::query()
            ->create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
            ]);

        $token = $coach->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $coach,
        ]);
    }
}

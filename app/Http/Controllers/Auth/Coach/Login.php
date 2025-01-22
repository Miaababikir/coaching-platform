<?php

namespace App\Http\Controllers\Auth\Coach;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $coach = Coach::query()
            ->where('email', $credentials['email'])
            ->first();

        if (!$coach) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        if (!Hash::check($credentials['password'], $coach->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $coach->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $coach,
        ]);
    }
}

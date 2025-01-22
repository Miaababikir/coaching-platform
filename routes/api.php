<?php

use App\Http\Controllers\Client\MarkCoachingSessionCompleted;
use App\Http\Controllers\Client\ScheduledCoachingSessions;
use App\Http\Controllers\Coach\ClientCoachingSessionProgress;
use App\Http\Controllers\Coach\CoachClientController;
use App\Http\Controllers\Coach\CoachingSessionController;
use App\Http\Controllers\Coach\TotalCoachingSessionConducted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("/auth")->group(function () {
    Route::post("/clients/login", \App\Http\Controllers\Auth\Client\Login::class);

    Route::post("/coaches/login", \App\Http\Controllers\Auth\Coach\Login::class);
    Route::post("/coaches/register", \App\Http\Controllers\Auth\Coach\Register::class);
});

Route::prefix("/clients")->middleware(["auth:client",])->group(function () {

    Route::get("/coaching-sessions/scheduled", ScheduledCoachingSessions::class);
    Route::put("/coaching-sessions/{id}/completed", MarkCoachingSessionCompleted::class);

});

Route::prefix("/coaches")->middleware(["auth:coach"])->group(function () {
    Route::get("/clients", [CoachClientController::class, "index"]);
    Route::post("/clients", [CoachClientController::class, "store"]);
    Route::get("/clients/{id}", [CoachClientController::class, "show"]);
    Route::put("/clients/{id}", [CoachClientController::class, "update"]);
    Route::delete("/clients/{id}", [CoachClientController::class, "destroy"]);

    Route::get("/coaching-sessions", [CoachingSessionController::class, "index"]);
    Route::post("/coaching-sessions", [CoachingSessionController::class, "store"]);
    Route::get("/coaching-sessions/{id}", [CoachingSessionController::class, "show"]);
    Route::put("/coaching-sessions/{id}", [CoachingSessionController::class, "update"]);
    Route::delete("/coaching-sessions/{id}", [CoachingSessionController::class, "destroy"]);

    Route::get("/analytics/total-sessions", TotalCoachingSessionConducted::class);
    Route::get("/analytics/session-progress", ClientCoachingSessionProgress::class);
});

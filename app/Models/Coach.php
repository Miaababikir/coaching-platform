<?php

namespace App\Models;

use App\Traits\IsUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coach extends User
{
    use IsUser;

    protected $table = 'users';

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }

    public function coachingSessions(): HasMany
    {
        return $this->hasMany(CoachingSession::class);
    }
}

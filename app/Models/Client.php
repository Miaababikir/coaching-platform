<?php

namespace App\Models;

use App\Traits\IsUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends User
{
    use IsUser;

    protected $table = 'users';

    public function coaches(): BelongsToMany
    {
        return $this->belongsToMany(Coach::class);
    }

    public function coachingSessions(): HasMany
    {
        return $this->hasMany(CoachingSession::class);
    }

}

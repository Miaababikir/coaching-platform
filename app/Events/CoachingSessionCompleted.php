<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CoachingSessionCompleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $id,
        public int $clientId,
        public int $coachId,
    )
    {
    }
}

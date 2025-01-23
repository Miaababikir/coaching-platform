<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CoachingSessionCreated
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

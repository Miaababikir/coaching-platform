<?php

namespace App\Dto;

class CreateCoachingSessionDto
{

    public function __construct(
        public int $clientId,
        public string $date,
    )
    {
    }

}

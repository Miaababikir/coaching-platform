<?php

namespace App\Dto;

class UpdateCoachingSessionDto
{
    public function __construct(
        public string $date,
    )
    {
    }
}

<?php

namespace App\Dto;

class UpdateClientDto
{

    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $password,
    ) {
    }

}

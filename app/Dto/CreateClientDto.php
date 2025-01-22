<?php

namespace App\Dto;

class CreateClientDto
{

    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }

}

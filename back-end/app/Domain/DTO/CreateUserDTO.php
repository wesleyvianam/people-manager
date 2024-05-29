<?php

declare(strict_types=1);

namespace App\Domain\DTO;

readonly class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $cpf,
    ) {
    }
}
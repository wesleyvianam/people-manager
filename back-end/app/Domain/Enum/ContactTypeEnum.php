<?php

namespace App\Domain\Enum;

enum ContactTypeEnum: int
{
    case EMAIL = 1;
    case PHONE = 2;

    public function getName(): string
    {
        return match ($this) {
            self::EMAIL => 'Email',
            self::PHONE => 'Celular',
        };
    }
}

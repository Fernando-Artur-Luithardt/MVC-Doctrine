<?php

declare(strict_types = 1);

namespace App\Enums;

enum Tipo: int
{
    case Telefone = 0;
    case Email    = 1;

    public function toString(): string
    {
        return match($this) {
            self::Telefone      => 'Telefone',
            self::Email         => 'Email',
            default             => 'Telefone'
        };
    }
}

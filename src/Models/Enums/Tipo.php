<?php

declare(strict_types = 1);

namespace Models\Enums;

enum Tipo: int
{
    case Telefone = 0;
    case Email    = 1;

    public function toString(): string
    {
        return match($this) {
            self::Email         => 'Email',
            default             => 'Telefone'
        };
    }
}
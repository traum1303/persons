<?php

namespace App\Enum;

enum PersonGender: string
{
    case MALE = 'MALE';
    case FEMALE = 'FEMALE';

    public function text(): string
    {
        return match ($this) {
            self::MALE => 'male',
            self::FEMALE => 'female',
        };
    }
}

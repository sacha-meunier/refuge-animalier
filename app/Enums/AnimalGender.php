<?php

namespace App\Enums;

enum AnimalGender: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public function label(): string
    {
        return match ($this) {
            self::MALE => __('animals.genders.male'),
            self::FEMALE => __('animals.genders.female'),
        };
    }
}

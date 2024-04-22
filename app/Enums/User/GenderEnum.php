<?php

namespace App\Enums\User;

use App\Enums\BaseEnum;

enum GenderEnum: int
{
    use BaseEnum;
    case MALE = 1;
    case FEMALE = 2;

    public static function badgesArray(): array
    {
        return [
            self::MALE->value => ['name' => __('main.male'), 'class' => 'badge-info'],
            self::FEMALE->value => ['name' => __('main.female'), 'class' => 'badge-secondary'],
        ];
    }
}

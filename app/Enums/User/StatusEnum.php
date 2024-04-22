<?php

namespace App\Enums\User;

use App\Enums\BaseEnum;

enum StatusEnum: int
{
    use BaseEnum;
    case ACTIVE = 1;
    case BANNED = 2;

    public static function badgesArray(): array
    {
        return [
            self::ACTIVE->value => ['name' => __('main.active'), 'class' => 'badge-success'],
            self::BANNED->value => ['name' => __('main.banned.0'), 'class' => 'badge-danger'],
        ];
    }
}

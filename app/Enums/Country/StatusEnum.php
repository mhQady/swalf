<?php

namespace App\Enums\Country;

use App\Enums\BaseEnum;

enum StatusEnum: int
{
    use BaseEnum;
    case ACTIVE = 1;
    case INACTIVE = 0;

    public static function badgesArray(): array
    {
        return [
            self::ACTIVE->value => ['name' => __('main.active'), 'class' => 'badge-success'],
            self::INACTIVE->value => ['name' => __('main.inactive'), 'class' => 'badge-secondary']
        ];
    }
}

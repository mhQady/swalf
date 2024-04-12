<?php

namespace App\Enums\Country;

use App\Enums\BaseEnum;

enum HasMarketEnum: int
{
    use BaseEnum;
    case YES = 1;
    case NO = 0;

    public static function badgesArray(): array
    {
        return [
            self::YES->value => [
                'name' => __('main.yes'),
                'class' => 'badge-success'
            ],
            self::NO->value => [
                'name' => __('main.no'),
                'class' => 'badge-danger'
            ]
        ];
    }
}

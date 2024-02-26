<?php

namespace App\Enums\User;

use App\Enums\BaseEnum;

enum GenderEnum: int
{
    use BaseEnum;
    case MALE = 1;
    case FEMALE = 2;
}

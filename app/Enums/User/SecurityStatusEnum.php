<?php

namespace App\Enums\User;

use App\Enums\BaseEnum;

enum SecurityStatusEnum: int
{
    use BaseEnum;
    case UNDER_REVIEW = 1;
    case PASS = 2;
    case REJECTED = 3;
}

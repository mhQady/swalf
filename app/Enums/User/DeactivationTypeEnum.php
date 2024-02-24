<?php

namespace App\Enums\User;

use App\Enums\BaseEnum;

enum DeactivationTypeEnum: int
{
    use BaseEnum;
    case BANNED_COUNTRY = 1;
    case SECURITY_REASON = 2;
}

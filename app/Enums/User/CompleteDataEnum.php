<?php

namespace App\Enums\User;

use App\Enums\BaseEnum;

enum CompleteDataEnum: int
{
    use BaseEnum;

    case NONE = 0;
    case PHONE_VERIFIED = 1;
    case PASSWORD_ENTERED = 2;
    case PERSONAL_INFO_ENTERED = 3;
    case FILES_UPLOADED = 4;
    case SECURITY_CHECKED = 5;
}

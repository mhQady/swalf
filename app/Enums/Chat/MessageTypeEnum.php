<?php

namespace App\Enums\Chat;

use App\Enums\BaseEnum;


enum MessageTypeEnum: int
{
    use BaseEnum;
    case TEXT = 1;
    case IMAGE = 2;
    case VOICE = 3;
}

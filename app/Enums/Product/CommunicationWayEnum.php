<?php

namespace App\Enums\Product;

use App\Enums\BaseEnum;

enum CommunicationWayEnum: int
{
    use BaseEnum;
    case CALL = 1;
    case SMS = 2;
    case IN_APP_CALL = 3;
    case CHAT = 4;
}

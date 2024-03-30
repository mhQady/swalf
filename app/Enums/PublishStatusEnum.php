<?php

namespace App\Enums;

use App\Enums\BaseEnum;

enum PublishStatusEnum: int
{

    use BaseEnum;

    case PUBLISHED = 1;
    case DRAFTED = 0;
}

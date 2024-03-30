<?php

namespace App\Enums\Media;

use App\Enums\BaseEnum;

enum MediaSourceEnum: string
{
    use BaseEnum;
    case PRODUCT = 'product';
}

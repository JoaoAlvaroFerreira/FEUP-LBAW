<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationType extends Enum
{
    const invite =   0;
    const comment =   1;
    const report = 2;
    const change = 3;
}

<?php

namespace App\Enums;

enum NotificationType
{
    case ALL;

    case FAILURE_ONLY;

    case NONE;
}

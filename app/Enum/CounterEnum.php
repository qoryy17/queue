<?php

namespace App\Enum;

enum CounterEnum: string
{
    case OPEN = "Open";
    case CLOSED = "Closed";
    case BREAK = "Break";
    case ENABLED = "Enabled";
    case DISABLED = "Disabled";
}

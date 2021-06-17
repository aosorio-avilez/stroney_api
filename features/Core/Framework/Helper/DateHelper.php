<?php

namespace Features\Core\Framework\Helper;

use Carbon\Carbon;

class DateHelper
{
    public static function getFormattedDate(?string $time = null, string $format = 'Y-m-d H:i:s'): string
    {
        return (new Carbon($time))->format($format);
    }
}

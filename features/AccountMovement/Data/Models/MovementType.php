<?php

namespace Features\AccountMovement\Data\Models;

use Features\Core\Data\EnumConverter;
use Spatie\Enum\Enum;

/**
 * @method static self income()
 * @method static self expense()
 */
class MovementType extends Enum
{
    use EnumConverter;

    protected static function labels(): array
    {
        return [
            'income' => __('income'),
            'expense' => __('expense'),
        ];
    }
}

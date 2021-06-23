<?php

namespace Features\Account\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class AdjustBalanceAccountValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'amount' => 'required|numeric',
        ];
    }

    public function getMessages(): array
    {
        return [
            'amount.required' => __('required', ['attribute' => 'amount']),
            'amount.numeric' => __('numeric', ['attribute' => 'amount']),
        ];
    }
}

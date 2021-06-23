<?php

namespace Features\User\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class CreateUserCurrencyValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'currency_id' => 'required|string',
            'exchange_rate' => 'required|numeric',
        ];
    }

    public function getMessages(): array
    {
        return [
            'currency_id.required' => __('required', ['attribute' => 'currency_id']),
            'exchange_rate.required' => __('required', ['attribute' => 'exchange_rate']),
            'exchange_rate.numeric' => __('numeric', ['attribute' => 'exchange_rate']),
        ];
    }
}

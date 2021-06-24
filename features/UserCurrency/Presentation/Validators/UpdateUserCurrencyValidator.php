<?php

namespace Features\UserCurrency\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class UpdateUserCurrencyValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'currency_id' => 'required|string',
            'base_exchange_rate' => 'required|numeric',
            'exchange_rate' => 'required|numeric',
        ];
    }

    public function getMessages(): array
    {
        return [
            'currency_id.required' => __('required', ['attribute' => 'currency_id']),
            'base_exchange_rate.required' => __('required', ['attribute' => 'base_exchange_rate']),
            'base_exchange_rate.numeric' => __('numeric', ['attribute' => 'base_exchange_rate']),
            'exchange_rate.required' => __('required', ['attribute' => 'exchange_rate']),
            'exchange_rate.numeric' => __('numeric', ['attribute' => 'exchange_rate']),
        ];
    }
}

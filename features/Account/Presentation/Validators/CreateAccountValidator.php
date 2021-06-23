<?php

namespace Features\Account\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class CreateAccountValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'user_id' => 'required',
            'user_currency_id' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric',
            'notes' => 'filled',
        ];
    }

    public function getMessages(): array
    {
        return [
            'user_id.required' => __('required', ['attribute' => 'user_id']),
            'user_currency_id.required' => __('required', ['attribute' => 'user_currency_id']),
            'name.required' => __('required', ['attribute' => 'name']),
            'amount.required' => __('required', ['attribute' => 'amount']),
            'amount.numeric' => __('numeric', ['attribute' => 'amount']),
            'notes.filled' => __('filled', ['attribute' => 'notes']),
        ];
    }
}

<?php

namespace Features\User\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class CreateUserValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => __('required', ['attribute' => 'name']),
            'email.required' => __('required', ['attribute' => 'email']),
            'email.email' => __('email', ['attribute' => 'email']),
            'password.required' => __('required', ['attribute' => 'password']),
            'password.min' => __('min', ['attribute' => 'password', 'min' => 8]),
        ];
    }
}

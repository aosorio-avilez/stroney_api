<?php

namespace Features\User\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class UpdatePasswordValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8',
        ];
    }

    public function getMessages(): array
    {
        return [
            'current_password.required' => __('required', ['attribute' => 'current_password']),
            'current_password.min' => __('min', ['attribute' => 'current_password', 'min' => 8]),
            'new_password.required' => __('required', ['attribute' => 'new_password']),
            'new_password.min' => __('min', ['attribute' => 'new_password', 'min' => 8]),
        ];
    }
}

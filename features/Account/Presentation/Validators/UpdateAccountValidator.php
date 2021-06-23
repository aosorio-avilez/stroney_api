<?php

namespace Features\Account\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class UpdateAccountValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'required',
            'notes' => 'filled',
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => __('required', ['attribute' => 'name']),
            'notes.filled' => __('filled', ['attribute' => 'notes']),
        ];
    }
}

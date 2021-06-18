<?php

namespace Features\User\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class UpdateUserValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'filled',
            'image' => 'filled|image'
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.filled' => __('filled', ['attribute' => 'name']),
            'image.filled' => __('filled', ['attribute' => 'image']),
            'image.image' => __('image', ['attribute' => 'image']),
        ];
    }
}

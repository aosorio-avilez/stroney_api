<?php

namespace Features\Category\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class CreateCategoryValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => __('required', ['attribute' => 'name']),
        ];
    }
}

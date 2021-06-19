<?php

namespace Features\Category\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class CreateCategoryValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'user_id' => 'required',
            'name' => 'required',
        ];
    }

    public function getMessages(): array
    {
        return [
            'user_id.required' => __('required', ['attribute' => 'user_id']),
            'name.required' => __('required', ['attribute' => 'name']),
        ];
    }
}

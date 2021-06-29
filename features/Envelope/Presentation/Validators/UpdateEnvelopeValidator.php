<?php
namespace Features\Envelope\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class UpdateEnvelopeValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'required',
            'amount' => 'required|numeric',
            'target_amount' => 'filled|numeric',
            'notes' => 'filled',
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => __('required', ['attribute' => 'name']),
            'amount.required' => __('required', ['attribute' => 'amount']),
            'amount.numeric' => __('numeric', ['attribute' => 'amount']),
            'target_amount.filled' => __('filled', ['attribute' => 'target_amount']),
            'target_amount.numeric' => __('numeric', ['attribute' => 'target_amount']),
            'notes.filled' => __('filled', ['attribute' => 'notes']),
        ];
    }
}

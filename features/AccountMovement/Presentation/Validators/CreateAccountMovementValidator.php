<?php

namespace Features\AccountMovement\Presentation\Validators;

use Features\AccountMovement\Data\Models\MovementType;
use Features\Core\Framework\Validator\BaseValidator;

class CreateAccountMovementValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'is_transfer' => 'required|boolean',
            'destination_account_id' => 'required_if:is_transfer,true|nullable',
            'category_id' => 'required|nullable',
            'amount' => 'required|numeric',
            'movement_type' => 'required|in:' . implode(',', MovementType::toValues()),
            'created_date' => 'required|date_format:Y-m-d',
            'created_time' => 'required|date_format:H:i',
            'notes' => 'required|nullable',
        ];
    }

    public function getMessages(): array
    {
        return [
            'is_transfer.required' => __('required', ['attribute' => 'is_transfer']),
            'is_transfer.boolean' => __('boolean', ['attribute' => 'is_transfer']),
            'destination_account_id.required_if' => __('required_if', ['attribute' => 'destination_account_id',]),
            'category_id.required' => __('required', ['attribute' => 'category_id']),
            'amount.required' => __('required', ['attribute' => 'amount']),
            'amount.numeric' => __('numeric', ['attribute' => 'amount']),
            'movement_type.required' => __('required', ['attribute' => 'movement_type']),
            'movement_type.in' => __('in', [
                'attribute' => 'movement_type',
                'values' => implode(',', MovementType::toValues())
            ]),
            'created_date.required' => __('required', ['attribute' => 'created_date']),
            'created_date.date_format' => __('date_format', [
                'attribute' => 'created_date',
                'fomrmat' => 'Y-m-d'
            ]),
            'created_time.required' => __('required', ['attribute' => 'created_time']),
            'created_time.date_format' => __('date_format', [
                'attribute' => 'created_time',
                'fomrmat' => 'H:i'
            ]),
            'notes.required' => __('required', ['attribute' => 'notes']),
        ];
    }
}

<?php
namespace Features\Envelope\Presentation\Validators;

use Features\Core\Framework\Validator\BaseValidator;

class TransferFromAccountValidator extends BaseValidator
{
    public function getRules(): array
    {
        return [
            'account_id' => 'required',
            'amount' => 'required|numeric',
            'created_date' => 'required|date_format:Y-m-d',
            'created_time' => 'required|date_format:H:i',
        ];
    }

    public function getMessages(): array
    {
        return [
            'account_id.required' => __('required', ['attribute' => 'account_id']),
            'amount.required' => __('required', ['attribute' => 'amount']),
            'amount.numeric' => __('numeric', ['attribute' => 'amount']),
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
        ];
    }
}

<?php

namespace Features\Core\Framework\Validator;

use Features\Core\Domain\Validator\Validator;
use Illuminate\Support\Facades\Validator as JsonValidator;

abstract class BaseValidator implements Validator
{
    abstract public function getRules(): array;

    abstract public function getMessages(): array;

    public function validate(array $data)
    {
        return JsonValidator::make($data, $this->getRules(), $this->getMessages())->validate();
    }
}

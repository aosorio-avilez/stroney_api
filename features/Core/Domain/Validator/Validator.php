<?php

namespace Features\Core\Domain\Validator;

interface Validator
{
    public function getRules(): array;

    public function validate(array $data);
}

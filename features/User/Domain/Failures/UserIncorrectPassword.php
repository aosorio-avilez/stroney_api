<?php

namespace Features\User\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class UserIncorrectPassword extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('user_incorrect_password'),
            400,
            'user_incorrect_password'
        );
    }
}

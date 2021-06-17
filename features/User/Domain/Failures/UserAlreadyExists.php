<?php

namespace Features\User\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class UserAlreadyExists extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('user_already_exists'),
            400,
            'user_already_exists'
        );
    }
}

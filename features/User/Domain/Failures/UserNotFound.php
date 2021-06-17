<?php

namespace Features\User\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class UserNotFound extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('user_not_found'),
            404,
            'user_not_found'
        );
    }
}

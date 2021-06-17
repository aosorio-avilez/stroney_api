<?php

namespace Features\User\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class UserBadCredentials extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('user_bad_credentials'),
            400,
            'user_bad_credentials'
        );
    }
}

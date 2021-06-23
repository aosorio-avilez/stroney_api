<?php

namespace Features\Account\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class AccountNotFound extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('account_not_found'),
            404,
            'account_not_found'
        );
    }
}

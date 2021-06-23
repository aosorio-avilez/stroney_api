<?php

namespace Features\UserCurrency\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class UserCurrencyNotFound extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('user_currency_not_found'),
            404,
            'user_currency_not_found'
        );
    }
}

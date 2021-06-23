<?php

namespace Features\UserCurrency\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class UserCurrencyAlreadyExists extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('user_currency_already_exists'),
            400,
            'user_currency_already_exists'
        );
    }
}

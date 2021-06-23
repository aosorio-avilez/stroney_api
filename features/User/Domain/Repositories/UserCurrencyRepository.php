<?php

namespace Features\User\Domain\Repositories;

use App\Models\UserCurrency;

interface UserCurrencyRepository
{
    public function create(UserCurrency $userCurrency): UserCurrency;

    public function getByCurrency(string $userId, string $currencyId): ?UserCurrency;
}

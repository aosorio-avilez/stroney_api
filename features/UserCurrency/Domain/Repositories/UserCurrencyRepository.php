<?php

namespace Features\UserCurrency\Domain\Repositories;

use App\Models\UserCurrency;

interface UserCurrencyRepository
{
    public function create(UserCurrency $userCurrency): UserCurrency;

    public function getByCurrency(string $userId, string $currencyId): ?UserCurrency;
    
    public function getById(string $userCurrencyId): ?UserCurrency;

    public function update(string $userCurrencyId, UserCurrency $userCurrency): UserCurrency;
    
    public function remove(string $userCurrencyId): bool;
}

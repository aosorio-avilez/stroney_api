<?php

namespace Features\Account\Domain\Repositories;

use App\Models\Account;

interface AccountRepository
{
    public function create(Account $account): Account;

    public function update(string $accountId, Account $account): Account;

    public function getById(string $accountId): ?Account;
}

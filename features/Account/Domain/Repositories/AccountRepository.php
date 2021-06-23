<?php

namespace Features\Account\Domain\Repositories;

use App\Models\Account;
use Illuminate\Support\Enumerable;

interface AccountRepository
{
    public function create(Account $account): Account;

    public function update(string $accountId, Account $account): Account;

    public function getById(string $accountId): ?Account;

    public function remove(string $accountId): bool;

    public function getByUser(string $userId): Enumerable;
}

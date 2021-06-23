<?php

namespace Features\Account\Domain\Repositories;

use App\Models\Account;

interface AccountRepository
{
    public function create(Account $account): Account;
}

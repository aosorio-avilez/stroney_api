<?php

namespace Features\AccountMovement\Domain\Repositories;

use App\Models\AccountMovement;
use Illuminate\Support\Enumerable;

interface AccountMovementRepository
{
    public function create(AccountMovement $accountMovement): AccountMovement;

    public function getByAccount(string $accountId): Enumerable;
}

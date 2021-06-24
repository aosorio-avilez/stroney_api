<?php

namespace Features\AccountMovement\Domain\Repositories;

use App\Models\AccountMovement;

interface AccountMovementRepository
{
    public function create(AccountMovement $accountMovement): AccountMovement;
}

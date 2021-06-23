<?php

namespace Features\Account\Domain\Usecases;

use App\Models\Account;
use Features\Account\Domain\Repositories\AccountRepository;

class UpdateAccountUseCase
{
    private AccountRepository $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $accountId, Account $account): Account
    {
        return $this->repository->update($accountId, $account);
    }
}

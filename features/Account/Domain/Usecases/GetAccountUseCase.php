<?php

namespace Features\Account\Domain\Usecases;

use App\Models\Account;
use Features\Account\Domain\Failures\AccountNotFound;
use Features\Account\Domain\Repositories\AccountRepository;

class GetAccountUseCase
{
    private AccountRepository $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $accountId): Account
    {
        $account =  $this->repository->getById($accountId);

        if ($account == null) {
            throw new AccountNotFound();
        }

        return $account;
    }
}

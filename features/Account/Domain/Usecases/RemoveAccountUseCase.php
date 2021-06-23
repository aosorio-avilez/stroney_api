<?php

namespace Features\Account\Domain\Usecases;

use Features\Account\Domain\Repositories\AccountRepository;

class RemoveAccountUseCase
{
    private AccountRepository $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $accountId): bool
    {
        return $this->repository->remove($accountId);
    }
}

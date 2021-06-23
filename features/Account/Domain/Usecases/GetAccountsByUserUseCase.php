<?php

namespace Features\Account\Domain\Usecases;

use Features\Account\Domain\Repositories\AccountRepository;

class GetAccountsByUserUseCase
{
    private AccountRepository $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userId): array
    {
        return $this->repository->getByUser($userId)->all();
    }
}

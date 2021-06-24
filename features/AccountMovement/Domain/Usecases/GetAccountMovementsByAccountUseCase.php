<?php

namespace Features\AccountMovement\Domain\Usecases;

use Features\AccountMovement\Domain\Repositories\AccountMovementRepository;
use Illuminate\Support\Enumerable;

class GetAccountMovementsByAccountUseCase
{
    private AccountMovementRepository $repository;

    public function __construct(AccountMovementRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $accountId): array
    {
        return $this->repository->getByAccount($accountId)->all();
    }
}

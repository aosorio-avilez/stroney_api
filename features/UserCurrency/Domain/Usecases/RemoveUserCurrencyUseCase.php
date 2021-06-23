<?php

namespace Features\UserCurrency\Domain\Usecases;

use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;

class RemoveUserCurrencyUseCase
{
    private UserCurrencyRepository $repository;

    public function __construct(UserCurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userCurrency): bool
    {
        return $this->repository->remove($userCurrency);
    }
}

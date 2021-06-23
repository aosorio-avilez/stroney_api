<?php

namespace Features\UserCurrency\Domain\Usecases;

use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;

class GetUserCurrenciesByUserUseCase
{
    private UserCurrencyRepository $repository;

    public function __construct(UserCurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userId): array
    {
        return $this->repository->getByUser($userId)->all();
    }
}

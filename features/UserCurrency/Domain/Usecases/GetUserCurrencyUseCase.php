<?php

namespace Features\UserCurrency\Domain\Usecases;

use App\Models\UserCurrency;
use Features\UserCurrency\Domain\Failures\UserCurrencyNotFound;
use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;

class GetUserCurrencyUseCase
{
    private UserCurrencyRepository $repository;

    public function __construct(UserCurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userCurrencyId): UserCurrency
    {
        $userCurrency = $this->repository->getById($userCurrencyId);

        if ($userCurrency == null) {
            throw new UserCurrencyNotFound();
        }

        return $userCurrency;
    }
}

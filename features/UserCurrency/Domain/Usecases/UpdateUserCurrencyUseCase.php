<?php

namespace Features\UserCurrency\Domain\Usecases;

use App\Models\UserCurrency;
use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;

class UpdateUserCurrencyUseCase
{
    private UserCurrencyRepository $repository;

    public function __construct(
        UserCurrencyRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function handle(string $userCurrencyId, UserCurrency $userCurrency): UserCurrency
    {
        return $this->repository->update($userCurrencyId, $userCurrency);
    }
}

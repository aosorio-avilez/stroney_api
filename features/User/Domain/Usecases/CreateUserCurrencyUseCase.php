<?php

namespace Features\User\Domain\Usecases;

use App\Models\UserCurrency;
use Features\User\Domain\Failures\UserCurrencyAlreadyExists;
use Features\User\Domain\Repositories\UserCurrencyRepository;

class CreateUserCurrencyUseCase
{
    private UserCurrencyRepository $repository;

    public function __construct(
        UserCurrencyRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function handle(string $userId, UserCurrency $userCurrency): UserCurrency
    {
        $userCurrencyFound = $this->repository->getByCurrency(
            $userId,
            $userCurrency->currency_id
        );

        if ($userCurrencyFound != null) {
            throw new UserCurrencyAlreadyExists();
        }

        $userCurrency->user_id = $userId;

        return $this->repository->create($userCurrency);
    }
}

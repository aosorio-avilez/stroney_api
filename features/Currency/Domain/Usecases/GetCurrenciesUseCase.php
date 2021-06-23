<?php

namespace Features\Currency\Domain\Usecases;

use Features\Currency\Domain\Repositories\CurrencyRepository;

class GetCurrenciesUseCase
{
    private CurrencyRepository $repository;

    public function __construct(CurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(): array
    {
        return $this->repository->getCurrencies()->all();
    }
}

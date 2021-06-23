<?php

use Features\Account\Data\Repositories\AccountRepositoryImpl;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\Category\Data\Repositories\CategoryRepositoryImpl;
use Features\Category\Domain\Repositories\CategoryRepository;
use Features\Currency\Data\Repositories\CurrencyRepositoryImpl;
use Features\Currency\Domain\Repositories\CurrencyRepository;
use Features\UserCurrency\Data\Repositories\UserCurrencyRepositoryImpl;
use Features\User\Data\Repositories\UserRepositoryImpl;
use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;
use Features\User\Domain\Repositories\UserRepository;

return [
    UserRepository::class => UserRepositoryImpl::class,
    CategoryRepository::class => CategoryRepositoryImpl::class,
    CurrencyRepository::class => CurrencyRepositoryImpl::class,
    UserCurrencyRepository::class => UserCurrencyRepositoryImpl::class,
    AccountRepository::class => AccountRepositoryImpl::class,
];

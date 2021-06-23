<?php

use Features\Category\Data\Repositories\CategoryRepositoryImpl;
use Features\Category\Domain\Repositories\CategoryRepository;
use Features\Currency\Data\Repositories\CurrencyRepositoryImpl;
use Features\Currency\Domain\Repositories\CurrencyRepository;
use Features\User\Data\Repositories\UserRepositoryImpl;
use Features\User\Domain\Repositories\UserRepository;

return [
    UserRepository::class => UserRepositoryImpl::class,
    CategoryRepository::class => CategoryRepositoryImpl::class,
    CurrencyRepository::class => CurrencyRepositoryImpl::class,
];

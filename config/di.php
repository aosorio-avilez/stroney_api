<?php

use Features\Category\Data\Repositories\CategoryRepositoryImpl;
use Features\Category\Domain\Repositories\CategoryRepository;
use Features\User\Data\Repositories\UserRepositoryImpl;
use Features\User\Domain\Repositories\UserRepository;

return [
    UserRepository::class => UserRepositoryImpl::class,
    CategoryRepository::class => CategoryRepositoryImpl::class,
];

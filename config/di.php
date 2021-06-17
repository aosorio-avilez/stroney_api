<?php

use Features\User\Data\Repositories\UserRepositoryImpl;
use Features\User\Domain\Repositories\UserRepository;

return [
    UserRepository::class => UserRepositoryImpl::class
];

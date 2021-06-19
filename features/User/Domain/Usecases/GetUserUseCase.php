<?php

namespace Features\User\Domain\Usecases;

use Features\User\Domain\Failures\UserNotFound;
use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;

class GetUserUseCase
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userId): User
    {
        $user = $this->repository->getById($userId);

        if ($user == null) {
            throw new UserNotFound();
        }

        return $user;
    }
}

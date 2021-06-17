<?php

namespace Features\User\Domain\Usecases;

use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;
use Features\User\Domain\Failures\UserAlreadyExists;

class CreateUserUseCase
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(User $user): User
    {
        $userFound = $this->repository->getByEmail($user->email);

        if ($userFound != null) {
            throw new UserAlreadyExists();
        }

        return $this->repository->create($user);
    }
}

<?php

namespace Features\User\Domain\Usecases;

use Features\User\Domain\Failures\UserNotFound;
use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;
use Features\User\Domain\Failures\UserIncorrectPassword;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordUseCase
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userId, string $password, string $newPassword): User
    {
        $currenUser = $this->repository->getById($userId);

        if ($currenUser == null) {
            throw new UserNotFound();
        }

        if (!Hash::check($password, $currenUser->password)) {
            throw new UserIncorrectPassword();
        }

        $currenUser->password = Hash::make($newPassword);

        return $this->repository->update($userId, $currenUser);
    }
}

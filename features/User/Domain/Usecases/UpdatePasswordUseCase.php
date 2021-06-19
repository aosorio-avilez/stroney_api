<?php

namespace Features\User\Domain\Usecases;

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

    public function handle(User $user, string $password, string $newPassword): User
    {
        if (!Hash::check($password, $user->password)) {
            throw new UserIncorrectPassword();
        }

        $user->password = Hash::make($newPassword);

        return $this->repository->update($user->id, $user);
    }
}

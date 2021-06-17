<?php

namespace Features\User\Domain\Usecases;

use Features\User\Domain\Entities\Auth;
use Features\User\Domain\Failures\UserBadCredentials;
use Features\User\Domain\Failures\UserNotFound;
use Features\User\Domain\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthenticateUseCase
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $email, string $password): Auth
    {
        $user = $this->repository->getByEmail($email);

        if ($user == null) {
            throw new UserNotFound();
        }
        
        if (!Hash::check($password, $user->password)) {
            throw new UserBadCredentials();
        }

        $token = $user->createToken($user->email);

        return new Auth($user, $token->plainTextToken);
    }
}

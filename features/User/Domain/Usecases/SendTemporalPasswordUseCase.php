<?php

namespace Features\User\Domain\Usecases;

use App\Events\SendTemporalPassword;
use App\Models\User;
use Features\User\Domain\Failures\UserNotFound;
use Features\User\Domain\Repositories\UserRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class SendTemporalPasswordUseCase
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $email): User
    {
        $userFound = $this->repository->getByEmail($email);

        if ($userFound == null) {
            throw new UserNotFound();
        }

        $temporalPassword = $this->randomPassword();
        $userFound->password = Hash::make($temporalPassword);

        $user = $this->repository->update($userFound->id, $userFound);

        Event::dispatch(new SendTemporalPassword(
            $user,
            $temporalPassword
        ));

        return $user;
    }
    
    private function randomPassword(int $lenght = 8)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $lenght; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}

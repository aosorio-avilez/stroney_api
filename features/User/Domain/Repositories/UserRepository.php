<?php

namespace Features\User\Domain\Repositories;

use App\Models\User;

interface UserRepository
{
    public function getByEmail(string $email): ?User;

    public function create(User $user): User;
}

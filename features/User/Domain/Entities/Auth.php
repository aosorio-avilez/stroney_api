<?php

namespace Features\User\Domain\Entities;

use App\Models\User;

class Auth
{
    public User $user;
    public string $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
}

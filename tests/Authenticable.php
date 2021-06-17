<?php

namespace Tests;

use App\Features\User\Data\Models\Profile;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait Authenticable
{
    protected User $user;

    public function buildAuthUser()
    {
        $this->user = User::factory()->create();

        Sanctum::actingAs(
            $this->user,
            ['*']
        );
    }
}

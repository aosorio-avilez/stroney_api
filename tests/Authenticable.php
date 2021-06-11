<?php

namespace Tests;

use App\Features\User\Data\Models\Profile;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait Authenticable
{
    protected User $user;

    public function buildAuthUser(?Profile $profile = null)
    {
        $this->user = User::factory()->create([
            'profile' => $profile != null ? $profile : Profile::admin()
        ]);

        Sanctum::actingAs(
            $this->user,
            [$this->user->profile->value]
        );
    }
}

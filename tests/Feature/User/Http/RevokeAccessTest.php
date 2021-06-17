<?php

namespace Tests\Feature\User\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\Authenticable;
use Tests\TestCase;

class RevokeAccessTest extends TestCase
{
    use DatabaseTransactions, Authenticable;

    /**
     * @group users
     * @test
    */
    public function shouldReturnUnauthorizedWhenTryToRevokeUnexistentAccess()
    {
        // Act
        $response = $this->deleteJson('/api/users/revoke-access');

        // Assert
        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'error_code',
                'message',
                'errors'
            ]);
    }

    /**
     * @group users
     * @test
    */
    public function shouldReturnNoContentWhenValidAccessRevoked()
    {
        // Arrange
        $this->buildAuthUser();

        // Act
        $response = $this->deleteJson('/api/users/revoke-access');

        // Assert
        $response->assertStatus(204);
    }
}

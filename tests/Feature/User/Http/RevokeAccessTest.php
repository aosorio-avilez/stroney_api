<?php

namespace Tests\Feature\User\Http;

use Illuminate\Foundation\Testing\DatabaseTransactions;
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

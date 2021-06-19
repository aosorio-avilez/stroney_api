<?php

namespace Tests\Feature\User\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SendTemporalPasswordTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @group users
     * @test
    */
    public function shouldReturnNotFoundWhenInvalidEmailProvided()
    {
        // Arrange
        $invalidEmail = "invalid@mail.com";

        // Act
        $response = $this->patchJson("/api/users/email/$invalidEmail/temporal-password");

        // Assert
        $response
            ->assertStatus(404)
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
    public function shouldReturnNoContentWhenValidEmailProvided()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->patchJson("/api/users/email/$user->email/temporal-password");

        // Assert
        $response->assertStatus(204);
    }
}

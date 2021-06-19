<?php

namespace Tests\Feature\User\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\Authenticable;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use DatabaseTransactions, Authenticable;

    public function setUp(): void
    {
        parent::setUp();
        $this->buildAuthUser();
    }

    /**
     * @group users
     * @test
    */
    public function shouldReturnOkWhenValidDataProvided()
    {
        // Arrange
        $currentPassword = "12345678";
        $newPassword = "87654321";
        $user = User::factory()->create([
            'password' => Hash::make($currentPassword)
        ]);
        $data = [
            'current_password' => $currentPassword,
            'new_password' => $newPassword
        ];

        // Act
        $response = $this->actingAs($this->user)
            ->patchJson("/api/users/{$user->id}/password", $data);

        // Assert
        $response->assertStatus(204);
    }

    /**
     * @group users
     * @test
    */
    public function shouldReturnNotFoundWhenInvalidUserIdProvided()
    {
        // Arrange
        $currentPassword = "12345678";
        $newPassword = "87654321";
        User::factory()->create([
            'password' => Hash::make($currentPassword)
        ]);
        $data = [
            'current_password' => $currentPassword,
            'new_password' => $newPassword
        ];

        // Act
        $response = $this->actingAs($this->user)
            ->patchJson("/api/users/invalid_id/password", $data);

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
    public function shouldReturnBadRequestWhenInvalidPasswordProvided()
    {
        // Arrange
        $invalidPassword = "invalid_password";
        $currentPassword = "12345678";
        $newPassword = "87654321";
        $user = User::factory()->create([
            'password' => Hash::make($currentPassword)
        ]);
        $data = [
            'current_password' => $invalidPassword,
            'new_password' => $newPassword
        ];

        // Act
        $response = $this->actingAs($this->user)
            ->patchJson("/api/users/$user->id/password", $data);

        // Assert
        $response
            ->assertStatus(400)
            ->assertJsonStructure([
                'error_code',
                'message',
                'errors'
            ]);
    }
}

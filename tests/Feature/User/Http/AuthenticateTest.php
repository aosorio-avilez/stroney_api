<?php

namespace Tests\Feature\User\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @group users
     * @test
    */
    public function shouldReturnNotFoundWhenInvalidEmailProvided()
    {
        // Arrange
        $invalidEmail = 'invalid@mail.com';
        $password = '12345678';
        User::factory()->create();

        // Act
        $response = $this->postJson('/api/users/auth', [
            'email' => $invalidEmail,
            'password' => $password,
        ]);

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
        $validEmail = 'email@mail.com';
        $invalidPassword = 'invalid_password';
        User::factory()->create([
            'email' => $validEmail
        ]);

        // Act
        $response = $this->postJson('/api/users/auth', [
            'email' => $validEmail,
            'password' => $invalidPassword,
        ]);
        
        // Assert
        $response
            ->assertStatus(400)
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
    public function shouldReturnOkWhenValidCredentialsProvided()
    {
        // Arrange
        $validEmail = 'mail@mail.com';
        $validPassword = '12345678';
        User::factory()->create([
            'email' => $validEmail,
            'password' => Hash::make($validPassword)
        ]);

        // Act
        $response = $this->postJson('/api/users/auth', [
            'email' => $validEmail,
            'password' => $validPassword,
        ]);
        
        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'user',
                    'token',
                ]
            ]);
    }
}

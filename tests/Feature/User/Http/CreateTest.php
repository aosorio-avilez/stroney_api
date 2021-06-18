<?php

namespace Tests\Feature\User\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @group users
     * @test
    */
    public function shouldReturnBadRequestWhenExistentEmailProvided()
    {
        // Arrange
        $existentEmail = 'fake@mail.com';
        $user = User::factory()->create([
            'email' => $existentEmail
        ]);
        $data = [
            'name' => $user->name,
            'email' => $existentEmail,
            'password' => '12345678'
        ];

        // Act
        $response = $this->postJson('/api/users', $data);

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
    public function shouldReturnCreatedWhenValidDataProvided()
    {
        // Arrange
        $user = User::factory()->make();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '12345678'
        ];

        // Act
        $response = $this->postJson('/api/users', $data);

        // Assert
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'image_url'
                ]
            ]);
    }
}

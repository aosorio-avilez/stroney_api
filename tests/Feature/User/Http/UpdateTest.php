<?php

namespace Tests\Feature\User\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Authenticable;
use Tests\TestCase;

class UpdateTest extends TestCase
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
        Storage::fake('testing');
        $user = User::factory()->make();
        $data = [
            'name' => $user->name,
            'image' => UploadedFile::fake()->create('fake.jpg'),
        ];

        // Act
        $response = $this->actingAs($this->user)
            ->putJson("/api/users/{$this->user->id}", $data);
        dd($response);
        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'image_url',
                ]
            ]);
    }
}

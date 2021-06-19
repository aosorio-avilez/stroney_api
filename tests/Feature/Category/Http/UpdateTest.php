<?php

namespace Tests\Feature\Category\Http;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
     * @group categories
     * @test
    */
    public function shouldReturnOkWhenValidDataProvided()
    {
        // Arrange
        $category = Category::factory()->create();

        // Act
        $response = $this->actingAs($this->user)
            ->putJson(
                "/api/users/{$this->user->id}/categories/$category->id",
                $category->toArray()
            );
        
        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ]
            ]);
    }
}

<?php

namespace Tests\Feature\Category\Http;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class CreateTest extends TestCase
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
    public function shouldReturnCreatedWhenValidDataProvided()
    {
        // Arrange
        $category = Category::factory()->make();

        // Act
        $response = $this->actingAs($this->user)
            ->postJson("/api/categories", $category->toArray());
            
        // Assert
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ]
            ]);
    }
}

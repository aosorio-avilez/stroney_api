<?php

namespace Tests\Feature\Category\Http;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class GetTest extends TestCase
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
            ->getJson("/api/categories/$category->id");
        
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

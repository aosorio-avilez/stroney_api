<?php

namespace Tests\Feature\Category\Http;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class DeleteTest extends TestCase
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
    public function shouldReturnNoContentWhenValidDataProvided()
    {
        // Arrange
        $category = Category::factory()->create();

        // Act
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/users/{$this->user->id}/categories/$category->id");
        
        // Assert
        $response->assertStatus(204);
    }
}

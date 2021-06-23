<?php

namespace Tests\Feature\UserCurrency\Http;

use App\Models\UserCurrency;
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
     * @group user-currencies
     * @test
    */
    public function shouldReturnNoContentWhenValidDataProvided()
    {
        // Arrange
        $userCurrency = UserCurrency::factory()->create();

        // Act
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/users/{$this->user->id}/currencies/$userCurrency->id");
        
        // Assert
        $response->assertStatus(204);
    }
}

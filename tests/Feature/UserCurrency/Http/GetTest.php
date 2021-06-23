<?php

namespace Tests\Feature\UserCurency\Http;

use App\Models\UserCurrency;
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
     * @group user-currencies
     * @test
    */
    public function shouldReturnOkWhenValidDataProvided()
    {
        // Arrange
        $userCurrency = UserCurrency::factory()->create();

        // Act
        $response = $this->actingAs($this->user)
            ->getJson("/api/users/$userCurrency->user_id/currencies");
        
        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'currency',
                    'exchange_rate',
                ]]
            ]);
    }
}

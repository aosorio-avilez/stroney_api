<?php

namespace Tests\Feature\UserCurrency\Http;

use App\Models\UserCurrency;
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
     * @group user-currencies
     * @test
    */
    public function shouldReturnNotFoundWhenUserCurrencyNotExistsProvided()
    {
        // Arrange
        $currentUserCurrency = UserCurrency::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $userCurrency = UserCurrency::factory()->make([
            'currency_id' => $currentUserCurrency->currency_id
        ]);

        // Act
        $response = $this->putJson(
            "/api/users/{$this->user->id}/currencies/invalid_id",
            $userCurrency->toArray()
        );

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
     * @group user-currencies
     * @test
    */
    public function shouldReturnCreatedWhenValidDataProvided()
    {
        // Arrange
        $userCurrency = UserCurrency::factory()->create();

        // Act
        $response = $this->putJson(
            "/api/users/{$this->user->id}/currencies/$userCurrency->id",
            $userCurrency->toArray()
        );

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'currency',
                    'exchange_rate',
                ]
            ]);
    }
}

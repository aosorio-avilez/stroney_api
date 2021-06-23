<?php

namespace Tests\Feature\User\Http;

use App\Models\UserCurrency;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class CreateUserCurrencyTest extends TestCase
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
    public function shouldReturnBadRequestWhenExistentCurrencyProvided()
    {
        // Arrange
        $currentUserCurrency = UserCurrency::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $userCurrency = UserCurrency::factory()->make([
            'currency_id' => $currentUserCurrency->currency_id
        ]);

        // Act
        $response = $this->postJson(
            "/api/users/{$this->user->id}/currencies",
            $userCurrency->toArray()
        );

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
        $userCurrency = UserCurrency::factory()->make();

        // Act
        $response = $this->postJson(
            "/api/users/{$this->user->id}/currencies",
            $userCurrency->toArray()
        );

        // Assert
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'currency',
                    'exchange_rate',
                ]
            ]);
    }
}

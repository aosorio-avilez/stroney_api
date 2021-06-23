<?php

namespace Tests\Feature\Account\Http;

use App\Models\Account;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class UpdateBalanceTest extends TestCase
{
    use DatabaseTransactions, Authenticable;

    public function setUp(): void
    {
        parent::setUp();
        $this->buildAuthUser();
    }

    /**
     * @group accounts
     * @test
    */
    public function shouldReturnOkWhenValidDataProvided()
    {
        // Arrange
        $account = Account::factory()->create();
       
        // Act
        $response = $this->actingAs($this->user)
            ->patchJson(
                "/api/accounts/$account->id/balance",
                ['amount' => 100]
            );
       
        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_currency',
                    'name',
                    'amount',
                    'notes',
                ]
            ]);
    }
}

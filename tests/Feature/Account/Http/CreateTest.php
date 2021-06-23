<?php

namespace Tests\Feature\Account\Http;

use App\Models\Account;
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
     * @group accounts
     * @test
    */
    public function shouldReturnCreatedWhenValidDataProvided()
    {
        // Arrange
        $account = Account::factory()->make();

        // Act
        $response = $this->actingAs($this->user)
            ->postJson("/api/accounts", $account->toArray());
            
        // Assert
        $response
            ->assertStatus(201)
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

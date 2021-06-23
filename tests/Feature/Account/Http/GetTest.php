<?php

namespace Tests\Feature\Account\Http;

use App\Models\Account;
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
     * @group accounts
     * @test
    */
    public function shouldReturnOkWhenValidDataProvided()
    {
        // Arrange
        $account = Account::factory()->create();

        // Act
        $response = $this->actingAs($this->user)
            ->getJson("/api/accounts/$account->id");
        
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

<?php

namespace Tests\Feature\AccountMovement\Http;

use App\Models\Account;
use App\Models\AccountMovement;
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
     * @group account-movements
     * @test
    */
    public function shouldReturnCreatedWhenValidDataProvided()
    {
        // Arrange
        $account = Account::factory()->create();
        $accountMovement = AccountMovement::factory()->make([
            'account_id' => $account->id
        ]);
        $data = array_merge($accountMovement->toArray(), [
            'is_transfer' => false
        ]);

        // Act
        $response = $this->actingAs($this->user)
            ->postJson("/api/accounts/$account->id/movements", $data);
        
        // Assert
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'account_id',
                    'destination_account_id',
                    'category_id',
                    'amount',
                    'movement_type',
                    'created_date',
                    'created_time',
                    'notes',
                ]
            ]);
    }
}

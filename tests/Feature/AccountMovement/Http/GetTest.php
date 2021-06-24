<?php

namespace Tests\Feature\AccountMovement\Http;

use App\Models\Account;
use App\Models\AccountMovement;
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
     * @group account-movements
     * @test
    */
    public function shouldReturnOkWhenValidDataProvided()
    {
        // Arrange
        $account = Account::factory()->create();
        AccountMovement::factory()->create([
            'account_id' => $account->id
        ]);

        // Act
        $response = $this->actingAs($this->user)
            ->getJson("/api/accounts/$account->id/movements");
        
        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' =>[[
                    'account',
                    'destination_account',
                    'category',
                    'amount',
                    'movement_type',
                    'created_date',
                    'created_time',
                    'notes',
                ]]
            ]);
    }
}

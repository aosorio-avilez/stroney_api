<?php

namespace Tests\Feature\User\Http;

use App\Models\Account;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class GetAccountsTest extends TestCase
{
    use DatabaseTransactions, Authenticable;

    public function setUp(): void
    {
        parent::setUp();
        $this->buildAuthUser();
    }

    /**
     * @group users
     * @test
    */
    public function shouldReturnOk()
    {
        // Arrange
        $user = User::factory()->create();
        Account::factory()->create([
            'user_id' => $user->id
        ]);

        // Act
        $response = $this->actingAs($this->user)
            ->getJson("/api/users/$user->id/accounts");
        
        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'user_currency',
                    'name',
                    'amount',
                    'notes',
                ]]
            ]);
    }
}

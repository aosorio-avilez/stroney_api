<?php

namespace Tests\Feature\Currency\Http;

use App\Models\Currency;
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
     * @group currencies
     * @test
    */
    public function shouldReturnOkWhenValidDataProvided()
    {
        // Arrange
        Currency::factory()->create();

        // Act
        $response = $this->actingAs($this->user)
            ->getJson("/api/currencies");
        
        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'code',
                    'name',
                    'exchange_rate',
                ]]
            ]);
    }
}

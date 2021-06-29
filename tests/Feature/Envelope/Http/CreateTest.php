<?php
namespace Tests\Feature\Envelope\Http;

use App\Models\Envelope;
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
     * @group envelopes
     * @test
    */
    public function shouldReturnCreatedWhenValidDataProvided()
    {
        // Arrange
        $envelope = Envelope::factory()->make();

        // Act
        $response = $this->actingAs($this->user)
            ->postJson('/api/envelopes', $envelope->toArray());

        // Assert
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'amount',
                    'target_amount',
                    'target_reached',
                    'notes',
                ]
            ]);
    }
}

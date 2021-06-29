<?php
namespace Tests\Feature\Envelope\Http;

use App\Models\AccountMovement;
use App\Models\Envelope;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class TransferTest extends TestCase
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
    public function shouldReturnOkWhenValidDataProvided()
    {
        // Arrange
        $envelope = Envelope::factory()->create();
        $accountMovement = AccountMovement::factory()->make();

        // Act
        $response = $this->actingAs($this->user)
            ->patchJson("/api/envelopes/$envelope->id/transfer", $accountMovement->toArray());

        // Assert
        $response
            ->assertStatus(200)
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

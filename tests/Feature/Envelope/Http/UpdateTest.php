<?php
namespace Tests\Feature\Envelope\Http;

use App\Models\Envelope;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class UpdateTest extends TestCase
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

        // Act
        $response = $this->actingAs($this->user)
            ->putJson("/api/envelopes/$envelope->id", $envelope->toArray());

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

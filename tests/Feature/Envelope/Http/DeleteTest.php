<?php
namespace Tests\Feature\Envelope\Http;

use App\Models\Envelope;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class DeleteTest extends TestCase
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
    public function shouldReturnNoContentWhenValidDataProvided()
    {
        // Arrange
        $envelope = Envelope::factory()->create();

        // Act
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/envelopes/$envelope->id");

        // Assert
        $response->assertStatus(204);
    }
}

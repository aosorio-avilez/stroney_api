<?php
namespace Tests\Feature\User\Http;

use App\Models\Envelope;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Authenticable;
use Tests\TestCase;

class GetEnvelopesTest extends TestCase
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
        Envelope::factory()->create([
            'user_id' => $user->id
        ]);

        // Act
        $response = $this->actingAs($this->user)
            ->getJson("/api/users/$user->id/envelopes");

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'name',
                    'amount',
                    'target_amount',
                    'target_reached',
                    'notes',
                ]]
            ]);
    }
}

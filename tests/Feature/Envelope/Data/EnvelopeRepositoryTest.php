<?php
namespace Tests\Feature\Envelope\Data;

use App\Models\Envelope;
use App\Models\User;
use Features\Envelope\Data\Repositories\EnvelopeRepositoryImpl;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EnvelopeRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private EnvelopeRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new EnvelopeRepositoryImpl();
    }

    /**
     * @group envelopes
     * @test
    */
    public function createShouldPersistInDatabase()
    {
        // Arrange
        $envelope = Envelope::factory()->make();

        // Act
        $result = $this->repository->create($envelope);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('envelopes', [
            'user_id' => $result->user_id,
            'name' => $result->name,
            'amount' => $result->amount,
            'target_amount' => $result->target_amount,
            'target_reached' => $result->target_reached,
            'notes' => $result->notes,
        ]);
    }

    /**
     * @group envelopes
     * @test
    */
    public function updateShouldUpdateInDatabase()
    {
        // Arrange
        $envelopeToUpdate = Envelope::factory()->create();
        $envelope = Envelope::factory()->make();

        // Act
        $result = $this->repository->update($envelopeToUpdate->id, $envelope);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('envelopes', [
            'id' => $envelopeToUpdate->id,
            'name' => $result->name,
            'amount' => $result->amount,
            'target_amount' => $result->target_amount,
            'target_reached' => $result->target_reached,
            'notes' => $result->notes,
        ]);
    }

    /**
     * @group envelopes
     * @test
    */
    public function getByIdShouldReturnFromDatabase()
    {
        // Arrange
        $envelope = Envelope::factory()->create();

        // Act
        $result = $this->repository->getById($envelope->id);

        // Assert
        $this->assertNotNull($result);
    }

    /**
    * @group envelopes
    * @test
    */
    public function removeShouldDeleteAccountFromDatabase()
    {
        // Arrange
        $envelope = Envelope::factory()->create();

        // Act
        $result = $this->repository->remove($envelope->id);

        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseMissing('envelopes', [
            'id' => $envelope->id
        ]);
    }

    /**
    * @group envelopes
    * @test
    */
    public function getByUserShouldReturnUserEnvelopesFromDatabase()
    {
        // Arrange
        $user = User::factory()->create();
        Envelope::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id
            ]);

        // Act
        $result = $this->repository->getByUser($user->id);

        // Assert
        $this->assertNotNull($result);
        $this->assertNotEmpty($result);
        $this->assertCount(10, $result);
    }
}

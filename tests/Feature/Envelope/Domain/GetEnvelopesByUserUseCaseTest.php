<?php
namespace Tests\Feature\Envelope\Domain;

use App\Models\Envelope;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;
use Features\Envelope\Domain\Usecases\GetEnvelopesByUserUseCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetEnvelopesByUserUseCaseTest extends TestCase
{
    /**
     * @var EnvelopeRepository|LegacyMockInterface
     */
    private $repository;

    private GetEnvelopesByUserUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var EnvelopeRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(EnvelopeRepository::class);
        $this->useCase = new GetEnvelopesByUserUseCase($this->repository);
    }

    /**
     * @group envelopes
     * @test
    */
    public function shouldReturnEnvelopes()
    {
        // Arrange
        $userId = Uuid::uuid1()->toString();
        $envelope = Mockery::mock(Envelope::class);
        $this->repository->shouldReceive('getByUser')
            ->andReturn(new Collection([$envelope]));

        // Act
        $result = $this->useCase->handle($userId);

        // Assert
        $this->assertNotEmpty($result);
    }
}

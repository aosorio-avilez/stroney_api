<?php
namespace Tests\Feature\Envelope\Domain;

use App\Models\Envelope;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;
use Features\Envelope\Domain\Usecases\UpdateEnvelopeUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UpdateEnvelopeUseCaseTest extends TestCase
{
    /**
     * @var EnvelopeRepository|LegacyMockInterface
     */
    private $repository;

    private UpdateEnvelopeUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var EnvelopeRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(EnvelopeRepository::class);
        $this->useCase = new UpdateEnvelopeUseCase($this->repository);
    }

    /**
     * @group envelopes
     * @test
    */
    public function shouldUpdateWhenValidAttributesProvided()
    {
        // Arrange
        $id = Uuid::uuid1()->toString();
        /**
         * @var Envelope
         */
        $envelope = Mockery::mock(Envelope::class, function ($mock) use ($id) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn($id);
        });
        $this->repository->shouldReceive('update')
            ->andReturn($envelope);

        // Act
        $result = $this->useCase->handle($envelope->id, $envelope);

        // Assert
        $this->assertNotNull($result);
    }
}

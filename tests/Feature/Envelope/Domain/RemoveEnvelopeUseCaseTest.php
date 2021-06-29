<?php
namespace Tests\Feature\Envelope\Domain;

use Features\Envelope\Domain\Repositories\EnvelopeRepository;
use Features\Envelope\Domain\Usecases\RemoveEnvelopeUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class RemoveEnvelopeUseCaseTest extends TestCase
{
    /**
     * @var EnvelopeRepository|LegacyMockInterface
     */
    private $repository;

    private RemoveEnvelopeUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var EnvelopeRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(EnvelopeRepository::class);
        $this->useCase = new RemoveEnvelopeUseCase($this->repository);
    }

    /**
     * @group envelopes
     * @test
    */
    public function shouldRemoveEnvelope()
    {
        // Arrange
        $id = Uuid::uuid1()->toString();
        $this->repository->shouldReceive('remove')
            ->andReturn(true);

        // Act
        $result = $this->useCase->handle($id);

        // Assert
        $this->assertTrue($result);
    }
}

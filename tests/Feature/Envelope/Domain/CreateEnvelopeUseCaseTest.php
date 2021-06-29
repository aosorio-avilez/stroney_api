<?php
namespace Tests\Feature\Envelope\Domain;

use App\Models\Envelope;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;
use Features\Envelope\Domain\Usecases\CreateEnvelopeUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class CreateEnvelopeUseCaseTest extends TestCase
{
    /**
     * @var EnvelopeRepository|LegacyMockInterface
     */
    private $repository;

    private CreateEnvelopeUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var EnvelopeRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(EnvelopeRepository::class);
        $this->useCase = new CreateEnvelopeUseCase($this->repository);
    }

    /**
     * @group envelopes
     * @test
    */
    public function shouldCreateWhenValidAttributesProvided()
    {
        // Arrange
        /**
         * @var Envelope
         */
        $envelope = Mockery::mock(Envelope::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn('GJHGJHGHJGJH');
            $mock->shouldReceive('setAttribute');
        });
        $this->repository->shouldReceive('create')
            ->andReturn($envelope);

        // Act
        $result = $this->useCase->handle($envelope->id, $envelope);

        // Assert
        $this->assertNotNull($result);
    }
}

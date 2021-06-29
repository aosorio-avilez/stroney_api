<?php
namespace Tests\Feature\Envelope\Domain;

use App\Models\Envelope;
use Features\Envelope\Domain\Failures\EnvelopeNotFound;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;
use Features\Envelope\Domain\Usecases\GetEnvelopeUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetEnvelopeUseCaseTest extends TestCase
{
    /**
     * @var EnvelopeRepository|LegacyMockInterface
     */
    private $repository;

    private GetEnvelopeUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var EnvelopeRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(EnvelopeRepository::class);
        $this->useCase = new GetEnvelopeUseCase($this->repository);
    }

    /**
     * @group envelopes
     * @test
    */
    public function shouldReturnEnvelopeWhenValidIdProvided()
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
        $this->repository->shouldReceive('getById')
            ->andReturn($envelope);

        // Act
        $result = $this->useCase->handle($envelope->id);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group envelopes
     * @test
    */
    public function shouldThrowEnvelopeNotFoundWhenInvalidIdProvided()
    {
        // Arrange
        $this->repository->shouldReceive('getById')
            ->andReturn(null);

        try {
            // Act
            $this->useCase->handle('invalid_id');
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(EnvelopeNotFound::class, $th);
        }
    }
}

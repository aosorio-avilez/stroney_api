<?php

namespace Tests\Feature\AccountMovement\Domain;

use App\Models\AccountMovement;
use Features\AccountMovement\Domain\Repositories\AccountMovementRepository;
use Features\AccountMovement\Domain\Usecases\GetAccountMovementsByAccountUseCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetAccountMovementsByAccountUseCaseTest extends TestCase
{
    /**
     * @var AccountMovementRepository|LegacyMockInterface
     */
    private $repository;

    private GetAccountMovementsByAccountUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var AccountMovementRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(AccountMovementRepository::class);
        $this->useCase = new GetAccountMovementsByAccountUseCase($this->repository);
    }

    /**
     * @group account-movements
     * @test
    */
    public function shouldReturnAccountMovements()
    {
        // Arrange
        $id = Uuid::uuid1()->toString();
        /**
         * @var MockInterface|AccountMovement
         */
        $accountMovement = Mockery::mock(AccountMovement::class);
       
        $this->repository->shouldReceive('getByAccount')
            ->andReturn(new Collection([$accountMovement]));

        // Act
        $result = $this->useCase->handle($id);

        // Assert
        $this->assertNotEmpty($result);
    }
}

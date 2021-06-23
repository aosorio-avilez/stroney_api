<?php

namespace Tests\Feature\Account\Domain;

use Features\Account\Domain\Repositories\AccountRepository;
use Features\Account\Domain\Usecases\RemoveAccountUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class RemoveAccountUseCaseTest extends TestCase
{
    /**
     * @var AccountRepository|LegacyMockInterface
     */
    private $repository;

    private RemoveAccountUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var AccountRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(AccountRepository::class);
        $this->useCase = new RemoveAccountUseCase($this->repository);
    }

    /**
     * @group accounts
     * @test
    */
    public function shouldRemoveAccount()
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

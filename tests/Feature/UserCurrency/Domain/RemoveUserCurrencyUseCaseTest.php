<?php

namespace Tests\Feature\UserCurrency\Domain;

use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;
use Features\UserCurrency\Domain\Usecases\RemoveUserCurrencyUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class RemoveUserCurrencyUseCaseTest extends TestCase
{
    /**
     * @var UserCurrencyRepository|LegacyMockInterface
     */
    private $repository;

    private RemoveUserCurrencyUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserCurrencyRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserCurrencyRepository::class);
        $this->useCase = new RemoveUserCurrencyUseCase($this->repository);
    }

    /**
     * @group user-currencies
     * @test
    */
    public function shouldRemoveUserCurrency()
    {
        // Arrange
        $userCurrencyId = Uuid::uuid1()->toString();
        $this->repository->shouldReceive('remove')
            ->andReturn(true);

        // Act
        $result = $this->useCase->handle($userCurrencyId);

        // Assert
        $this->assertTrue($result);
    }
}

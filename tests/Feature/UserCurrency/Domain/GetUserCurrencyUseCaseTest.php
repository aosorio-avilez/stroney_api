<?php

namespace Tests\Feature\UserCurrency\Domain;

use App\Models\UserCurrency;
use Features\UserCurrency\Domain\Failures\UserCurrencyNotFound;
use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;
use Features\UserCurrency\Domain\Usecases\GetUserCurrencyUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetUserCurrencyUseCaseTest extends TestCase
{
    /**
     * @var UserCurrencyRepository|LegacyMockInterface
     */
    private $repository;

    private GetUserCurrencyUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserCurrencyRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserCurrencyRepository::class);
        $this->useCase = new GetUserCurrencyUseCase($this->repository);
    }

    /**
     * @group user-currencies
     * @test
    */
    public function shouldReturnUserCurrencyWhenValidIdProvided()
    {
        // Arrange
        $id = Uuid::uuid1()->toString();
        /**
         * @var UserCurrency
         */
        $userCurrency = Mockery::mock(UserCurrency::class, function ($mock) use ($id) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn($id);
        });
        $this->repository->shouldReceive('getById')
            ->andReturn($userCurrency);

        // Act
        $result = $this->useCase->handle($userCurrency->id);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group user-currencies
     * @test
    */
    public function shouldThrowUserCurrencyNotFoundWhenInvalidIdProvided()
    {
        // Arrange
        $this->repository->shouldReceive('getById')
            ->andReturn(null);

        try {
            // Act
            $this->useCase->handle('invalid_id');
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(UserCurrencyNotFound::class, $th);
        }
    }
}

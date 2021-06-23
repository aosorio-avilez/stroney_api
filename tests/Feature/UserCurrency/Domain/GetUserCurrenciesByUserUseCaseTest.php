<?php

namespace Tests\Feature\UserCurrency\Domain;

use App\Models\UserCurrency;
use Features\UserCurrency\Domain\Usecases\GetUserCurrenciesByUserUseCase;
use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetUserCurrenciesByUserUseCaseTest extends TestCase
{
    /**
     * @var UserCurrencyRepository|LegacyMockInterface
     */
    private $repository;

    private GetUserCurrenciesByUserUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserCurrencyRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserCurrencyRepository::class);
        $this->useCase = new GetUserCurrenciesByUserUseCase($this->repository);
    }

    /**
     * @group user-currencies
     * @test
    */
    public function shouldReturnUserCurrencies()
    {
        // Arrange
        $userId = Uuid::uuid1()->toString();
        $userCurrency = Mockery::mock(UserCurrency::class);
        $this->repository->shouldReceive('getByUser')
            ->andReturn(new Collection([$userCurrency]));

        // Act
        $result = $this->useCase->handle($userId);

        // Assert
        $this->assertNotEmpty($result);
    }
}

<?php

namespace Tests\Feature\Currency\Domain;

use App\Models\Currency;
use Features\Currency\Domain\Repositories\CurrencyRepository;
use Features\Currency\Domain\Usecases\GetCurrenciesUseCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class GetCurrenciesUseCaseTest extends TestCase
{
    /**
     * @var CurrencyRepository|LegacyMockInterface
     */
    private $repository;

    private GetCurrenciesUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var CurrencyRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(CurrencyRepository::class);
        $this->useCase = new GetCurrenciesUseCase($this->repository);
    }

    /**
     * @group currencies
     * @test
    */
    public function shouldReturnCurrencies()
    {
        // Arrange
        $currency = Mockery::mock(Currency::class);
        $this->repository->shouldReceive('getCurrencies')
            ->andReturn(new Collection([$currency]));

        // Act
        $result = $this->useCase->handle();

        // Assert
        $this->assertNotEmpty($result);
    }
}

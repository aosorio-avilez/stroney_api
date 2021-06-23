<?php

namespace Tests\Feature\Currency\Data;

use App\Models\Currency;
use Features\Currency\Data\Repositories\CurrencyRepositoryImpl;
use Features\Currency\Domain\Repositories\CurrencyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CurrencyRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private CurrencyRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new CurrencyRepositoryImpl();
    }

    /**
     * @group currencies
     * @test
    */
    public function getCurrenciesShouldReturnCurrenciesFromDatabase()
    {
        // Arrange
        Currency::factory()->create();

        // Act
        $result = $this->repository->getCurrencies();

        // Assert
        $this->assertNotNull($result);
        $this->assertNotEmpty($result);
    }
}

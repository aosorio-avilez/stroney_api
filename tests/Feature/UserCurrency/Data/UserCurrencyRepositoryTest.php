<?php

namespace Tests\Feature\UserCurrency\Data;

use App\Models\UserCurrency;
use Features\UserCurrency\Data\Repositories\UserCurrencyRepositoryImpl;
use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserCurrencyRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private UserCurrencyRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserCurrencyRepositoryImpl();
    }

    /**
     * @group user-currencies
     * @test
    */
    public function createShouldPersistUserCurrencyInDatabase()
    {
        // Arrange
        $userCurrency = UserCurrency::factory()->make();

        // Act
        $result = $this->repository->create($userCurrency);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('user_currencies', [
            'user_id' => $result->user_id,
            'currency_id' => $result->currency_id,
            'exchange_rate' => $result->exchange_rate,
        ]);
    }

    /**
        * @group user-currencies
        * @test
       */
    public function getByCurrencyShouldReturnUserCurrencyFromDatabase()
    {
        // Arrange
        $userCurrency = UserCurrency::factory()->create();
        
        // Act
        $result = $this->repository->getByCurrency(
            $userCurrency->user_id,
            $userCurrency->currency_id
        );
        
        // Assert
        $this->assertNotNull($result);
    }

    /**
        * @group user-currencies
        * @test
       */
    public function getByIdShouldReturnUserCurrencyFromDatabase()
    {
        // Arrange
        $userCurrency = UserCurrency::factory()->create();
          
        // Act
        $result = $this->repository->getById($userCurrency->id);
          
        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group user-currencies
     * @test
    */
    public function updateShouldUpdateUserCurrencyInDatabase()
    {
        // Arrange
        $userCurrencyToUpdate = UserCurrency::factory()->create();
        $userCurrency = UserCurrency::factory()->make();

        // Act
        $result = $this->repository->update(
            $userCurrencyToUpdate->id,
            $userCurrency
        );

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('user_currencies', [
            'id' => $userCurrencyToUpdate->id,
            'user_id' => $result->user_id,
            'currency_id' => $result->currency_id,
            'exchange_rate' => $result->exchange_rate,
        ]);
    }
}

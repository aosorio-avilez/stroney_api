<?php

namespace Tests\Feature\Account\Data;

use App\Models\Account;
use Features\Account\Data\Repositories\AccountRepositoryImpl;
use Features\Account\Domain\Repositories\AccountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AccountRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private AccountRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new AccountRepositoryImpl();
    }

    /**
     * @group accounts
     * @test
    */
    public function createShouldPersistInDatabase()
    {
        // Arrange
        $account = Account::factory()->make();

        // Act
        $result = $this->repository->create($account);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('accounts', [
            'user_id' => $result->user_id,
            'user_currency_id' => $result->user_currency_id,
            'name' => $result->name,
            'amount' => $result->amount,
            'notes' => $result->notes,
        ]);
    }
}

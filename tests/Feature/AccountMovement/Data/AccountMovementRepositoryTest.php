<?php

namespace Tests\Feature\AccountMovement\Data;

use App\Models\AccountMovement;
use Features\AccountMovement\Data\Repositories\AccountMovementRepositoryImpl;
use Features\AccountMovement\Domain\Repositories\AccountMovementRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AccountMovementRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private AccountMovementRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new AccountMovementRepositoryImpl();
    }

    /**
     * @group account-movements
     * @test
    */
    public function createShouldPersistAccountMovementInDatabase()
    {
        // Arrange
        $movement = AccountMovement::factory()->make();

        // Act
        $result = $this->repository->create($movement);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('account_movements', [
            'account_id' => $result->account_id,
            'destination_account_id' => $result->destination_account_id,
            'category_id' => $result->category_id,
            'amount' => $result->amount,
            'movement_type' => $result->movement_type,
            'created_date' => $result->created_date,
            'created_time' => $result->created_time,
            'notes' => $result->notes,
        ]);
    }
}

<?php

namespace Tests\Feature\Account\Domain;

use App\Models\Account;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\Account\Domain\Usecases\GetAccountsByUserUseCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetAccountsByUserUseCaseTest extends TestCase
{
    /**
     * @var AccountRepository|LegacyMockInterface
     */
    private $repository;

    private GetAccountsByUserUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var AccountRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(AccountRepository::class);
        $this->useCase = new GetAccountsByUserUseCase($this->repository);
    }

    /**
     * @group accounts
     * @test
    */
    public function shouldReturnCategories()
    {
        // Arrange
        $userId = Uuid::uuid1()->toString();
        $account = Mockery::mock(Account::class);
        $this->repository->shouldReceive('getByUser')
            ->andReturn(new Collection([$account]));

        // Act
        $result = $this->useCase->handle($userId);

        // Assert
        $this->assertNotEmpty($result);
    }
}

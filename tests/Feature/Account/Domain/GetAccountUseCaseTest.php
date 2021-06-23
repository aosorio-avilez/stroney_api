<?php

namespace Tests\Feature\Account\Domain;

use App\Models\Account;
use Features\Account\Domain\Failures\AccountNotFound;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\Account\Domain\Usecases\GetAccountUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetAccountUseCaseTest extends TestCase
{
    /**
     * @var AccountRepository|LegacyMockInterface
     */
    private $repository;

    private GetAccountUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var AccountRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(AccountRepository::class);
        $this->useCase = new GetAccountUseCase($this->repository);
    }

    /**
     * @group accounts
     * @test
    */
    public function shouldReturnAccountWhenValidIdProvided()
    {
        // Arrange
        $id = Uuid::uuid1()->toString();
        /**
         * @var Account
         */
        $account = Mockery::mock(Account::class, function ($mock) use ($id) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn($id);
        });
        $this->repository->shouldReceive('getById')
            ->andReturn($account);

        // Act
        $result = $this->useCase->handle($account->id);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group accounts
     * @test
    */
    public function shouldThrowAccountNotFoundWhenInvalidIdProvided()
    {
        // Arrange
        $this->repository->shouldReceive('getById')
            ->andReturn(null);

        try {
            // Act
            $this->useCase->handle('invalid_id');
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(AccountNotFound::class, $th);
        }
    }
}

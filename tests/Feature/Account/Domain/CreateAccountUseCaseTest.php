<?php

namespace Tests\Feature\Account\Domain;

use App\Models\Account;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\Account\Domain\Usecases\CreateAccountUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class CreateAccountUseCaseTest extends TestCase
{
    /**
     * @var AccountRepository|LegacyMockInterface
     */
    private $repository;

    private CreateAccountUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var AccountRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(AccountRepository::class);
        $this->useCase = new CreateAccountUseCase($this->repository);
    }

    /**
     * @group accounts
     * @test
    */
    public function shouldCreateWhenValidAttributesProvided()
    {
        // Arrange
        /**
         * @var Account
         */
        $account = Mockery::mock(Account::class);
        $this->repository->shouldReceive('create')
            ->andReturn($account);

        // Act
        $result = $this->useCase->handle($account);

        // Assert
        $this->assertNotNull($result);
    }
}

<?php

namespace Tests\Feature\Account\Domain;

use App\Models\Account;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\Account\Domain\Usecases\UpdateAccountUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UpdateAccountUseCaseTest extends TestCase
{
    /**
     * @var AccountRepository|LegacyMockInterface
     */
    private $repository;

    private UpdateAccountUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var AccountRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(AccountRepository::class);
        $this->useCase = new UpdateAccountUseCase($this->repository);
    }

    /**
     * @group accounts
     * @test
    */
    public function shouldUpdateAccountWhenValidAttributesProvided()
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
        $this->repository->shouldReceive('update')
            ->andReturn($account);

        // Act
        $result = $this->useCase->handle($account->id, $account);

        // Assert
        $this->assertNotNull($result);
    }
}

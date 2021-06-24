<?php

namespace Tests\Feature\AccountMovement\Domain;

use App\Models\Account;
use App\Models\AccountMovement;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\AccountMovement\Domain\Repositories\AccountMovementRepository;
use Features\AccountMovement\Domain\Usecases\CreateAccountMovementUseCase;
use Features\AccountMovement\Domain\Usecases\MakeAccountTransferUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateAccountMovementUseCaseTest extends TestCase
{
    /**
     * @var AccountRepository|LegacyMockInterface
     */
    private $accountRepository;

    /**
     * @var AccountMovementRepository|LegacyMockInterface
     */
    private $repository;

    private CreateAccountMovementUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var AccountRepository|LegacyMockInterface
         */
        $this->accountRepository = Mockery::mock(AccountRepository::class);
        /**
         * @var AccountMovementRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(AccountMovementRepository::class);
        $this->useCase = new CreateAccountMovementUseCase(
            $this->repository,
            $this->accountRepository,
        );
    }

    /**
     * @group account-movements
     * @test
    */
    public function shouldMakeAccountTransferWhenValidAttributesProvided()
    {
        // Arrange
        /**
         * @var MockInterface|Account
         */
        $account = Mockery::mock(Account::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('amount')
                ->andReturn(500);
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn('skajhdajksdnklj');
            $mock->shouldReceive('setAttribute');
        });
        /**
         * @var MockInterface|AccountMovement
         */
        $accountMovement = Mockery::mock(AccountMovement::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('amount')
                ->andReturn(500);
            $mock->shouldReceive('getAttribute')
                ->with('account_id')
                ->andReturn('uytuyyugyugyu');
            $mock->shouldReceive('getAttribute')
                ->with('destination_account_id')
                ->andReturn('asdkjasdlkan');
            $mock->shouldReceive('replicate')
                ->andReturn($mock);
            $mock->shouldReceive('setAttribute');
        });
        $accountMovement->makePartial();
        $this->accountRepository->shouldReceive('getById')
            ->andReturn($account);
        $this->accountRepository->shouldReceive('update')
            ->andReturn($account);
        $this->repository->shouldReceive('create')
            ->andReturn($accountMovement);

        // Act
        $result = $this->useCase->handle($accountMovement, false);
        
        // Assert
        $this->assertNotNull($result);
    }
}

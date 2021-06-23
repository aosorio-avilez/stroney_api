<?php

namespace Tests\Feature\User\Domain;

use App\Models\Currency;
use App\Models\User;
use App\Models\UserCurrency;
use Features\Currency\Domain\Repositories\CurrencyRepository;
use Features\User\Domain\Failures\UserCurrencyAlreadyExists;
use Features\User\Domain\Repositories\UserCurrencyRepository;
use Features\User\Domain\Usecases\CreateUserCurrencyUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class CreateUserCurrencyUseCaseTest extends TestCase
{
    /**
     * @var UserCurrencyRepository|LegacyMockInterface
     */
    private $repository;

    private CreateUserCurrencyUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserCurrencyRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserCurrencyRepository::class);
        $this->useCase = new CreateUserCurrencyUseCase(
            $this->repository
        );
    }

    /**
     * @group user-currencies
     * @test
    */
    public function shouldCreateUserCurrencyWhenValidAttributesProvided()
    {
        // Arrange
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn('JNAKJJSD87687687');
        });
       
        /**
         * @var UserCurrency
         */
        $userCurrency = Mockery::mock(UserCurrency::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('currency_id')
                ->andReturn('JNAKJJSD87687687');
            $mock->shouldReceive('setAttribute');
        });

        $this->repository->shouldReceive('getBycurrency')
            ->andReturn(null);
        $this->repository->shouldReceive('create')
            ->andReturn($userCurrency);

        // Act
        $result = $this->useCase->handle($user->id, $userCurrency);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group user-currencies
     * @test
    */
    public function shouldThrowUserCurrencyAlreadyExistsWhenExistentCurrencyProvided()
    {
        // Arrange
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn('JNAKJJSD87687687');
        });
        /**
         * @var UserCurrency
         */
        $userCurrency = Mockery::mock(UserCurrency::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('currency_id')
                ->andReturn('JNAKJJSD87687687');
            $mock->shouldReceive('setAttribute');
        });

        $this->repository->shouldReceive('getByCurrency')
            ->andReturn($userCurrency);

        try {
            // Act
            $this->useCase->handle($user->id, $userCurrency);
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(UserCurrencyAlreadyExists::class, $th);
        }
    }
}

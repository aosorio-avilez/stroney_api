<?php

namespace Tests\Feature\UserCurrency\Domain;

use App\Models\UserCurrency;
use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;
use Features\UserCurrency\Domain\Usecases\UpdateUserCurrencyUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class UpdateUserCurrencyUseCaseTest extends TestCase
{
    /**
     * @var UserCurrencyRepository|LegacyMockInterface
     */
    private $repository;

    private UpdateUserCurrencyUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserCurrencyRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserCurrencyRepository::class);
        $this->useCase = new UpdateUserCurrencyUseCase(
            $this->repository
        );
    }

    /**
     * @group user-currencies
     * @test
    */
    public function shouldUpdateUserCurrencyWhenValidAttributesProvided()
    {
        // Arrange
        /**
         * @var UserCurrency
         */
        $userCurrency = Mockery::mock(UserCurrency::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn('JNAKJJSD87687687');
            $mock->shouldReceive('setAttribute');
        });

        $this->repository->shouldReceive('getById')
            ->andReturn($userCurrency);
        $this->repository->shouldReceive('update')
            ->andReturn($userCurrency);

        // Act
        $result = $this->useCase->handle($userCurrency->id, $userCurrency);

        // Assert
        $this->assertNotNull($result);
    }
}

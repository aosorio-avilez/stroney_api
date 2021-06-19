<?php

namespace Tests\Feature\User\Domain;

use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;
use Features\User\Domain\Failures\UserNotFound;
use Features\User\Domain\Usecases\GetUserUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetUserUseCaseTest extends TestCase
{
    /**
     * @var UserRepository|LegacyMockInterface
     */
    private $repository;

    private GetUserUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserRepository::class);
        $this->useCase = new GetUserUseCase($this->repository);
    }

    /**
     * @group users
     * @test
    */
    public function shouldReturnUserWhenValidUserIdProvided()
    {
        // Arrange
        $userId = Uuid::uuid1()->toString();
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) use ($userId) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn($userId);
        });
        $this->repository->shouldReceive('getById')
            ->andReturn($user);

        // Act
        $result = $this->useCase->handle($user->id);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group users
     * @test
    */
    public function shouldThrowUserNotFoundWhenInvalidIdProvided()
    {
        // Arrange
        $this->repository->shouldReceive('getById')
            ->andReturn(null);

        try {
            // Act
            $this->useCase->handle('invalid_id');
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(UserNotFound::class, $th);
        }
    }
}

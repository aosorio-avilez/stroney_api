<?php

namespace Tests\Feature\User\Domain;

use Features\User\Domain\Repositories\UserRepository;
use Features\User\Domain\Usecases\CreateUserUseCase;
use App\Models\User;
use Features\User\Domain\Failures\UserAlreadyExists;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class CreateUserUseCaseTest extends TestCase
{
    /**
     * @var UserRepository|LegacyMockInterface
     */
    private $repository;

    private CreateUserUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserRepository::class);
        $this->useCase = new CreateUserUseCase($this->repository);
    }

    /**
     * @group users
     * @test
    */
    public function shouldCreateUserWhenValidAttributesProvided()
    {
        // Arrange
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('name')
                ->andReturn('User');
            $mock->shouldReceive('getAttribute')
                ->with('email')
                ->andReturn('admin@mail.com');
            $mock->shouldReceive('getAttribute')
                ->with('password')
                ->andReturn('12345678');
            $mock->shouldReceive('setAttribute');
        });
        $this->repository->shouldReceive('getByEmail')
            ->andReturn(null);
        $this->repository->shouldReceive('create')
            ->andReturn($user);

        // Act
        $result = $this->useCase->handle($user);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group users
     * @test
    */
    public function shouldThrowUserAlreadyExistsWhenExistentEmailProvided()
    {
        // Arrange
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('email')
                ->andReturn('admin@mail.com');
            $mock->shouldReceive('setAttribute');
        });

        $this->repository->shouldReceive('getByEmail')
            ->andReturn($user);

        try {
            // Act
            $this->useCase->handle($user);
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(UserAlreadyExists::class, $th);
        }
    }
}

<?php

namespace Tests\Feature\User\Domain;

use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;
use Features\User\Domain\Failures\UserIncorrectPassword;
use Features\User\Domain\Failures\UserNotFound;
use Features\User\Domain\Usecases\UpdatePasswordUseCase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class UpdatePasswordUseCaseTest extends TestCase
{
    /**
     * @var UserRepository|LegacyMockInterface
     */
    private $repository;

    private UpdatePasswordUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserRepository::class);
        $this->useCase = new UpdatePasswordUseCase($this->repository);
    }

    /**
     * @group users
     * @test
    */
    public function shouldUpdatePasswordWhenValidAttributesProvided()
    {
        // Arrange
        $currentPassword = "12345678";
        $newPassword = "87654321";
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) use ($currentPassword) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn("jasdhkjasdh");
            $mock->shouldReceive('getAttribute')
                ->with('password')
                ->andReturn(Hash::make($currentPassword));
            $mock->shouldReceive('setAttribute');
        });
        $this->repository->shouldReceive('getById')
            ->andReturn($user);
        $this->repository->shouldReceive('update')
            ->andReturn($user);

        // Act
        $result = $this->useCase->handle(
            $user->id,
            $currentPassword,
            $newPassword
        );

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
        $currentPassword = "12345678";
        $newPassword = "87654321";
        $this->repository->shouldReceive('getById')
            ->andReturn(null);

        try {
            // Act
            $this->useCase->handle(
                'invalid_id',
                $currentPassword,
                $newPassword
            );
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(UserNotFound::class, $th);
        }
    }

    /**
     * @group users
     * @test
    */
    public function shouldThrowUserIncorrectPasswordWhenInvalidPasswordProvided()
    {
        // Arrange
        $invalidPassword = "invalid";
        $currentPassword = "12345678";
        $newPassword = "87654321";
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) use ($currentPassword) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn("jasdhkjasdh");
            $mock->shouldReceive('getAttribute')
                ->with('password')
                ->andReturn($currentPassword);
            $mock->shouldReceive('setAttribute');
        });
        $this->repository->shouldReceive('getById')
            ->andReturn($user);
        $this->repository->shouldReceive('update')
            ->andReturn($user);

        try {
            // Act
            $this->useCase->handle(
                $user->id,
                $invalidPassword,
                $newPassword
            );
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(UserIncorrectPassword::class, $th);
        }
    }
}

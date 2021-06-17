<?php

namespace Tests\Feature\User\Domain;

use Features\User\Domain\Failures\UserBadCredentials;
use Features\User\Domain\Failures\UserNotFound;
use Features\User\Domain\Repositories\UserRepository;
use Features\User\Domain\Usecases\AuthenticateUseCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class AuthenticateUseCaseTest extends TestCase
{
    /**
     * @var UserRepository|LegacyMockInterface
     */
    private $repository;

    private AuthenticateUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserRepository::class);
        $this->useCase = new AuthenticateUseCase($this->repository);
    }

    /**
     * @group users
     * @test
    */
    public function shouldAuthenticateUserWhenValidCredentialsProvided()
    {
        // Arrange
        $validEmail = 'admin@mail.com';
        $validPassword = '12345678';
        $user = Mockery::mock(User::class, function ($mock) use ($validEmail, $validPassword) {
            $mock->shouldReceive('getAttribute')
                ->with('email')
                ->andReturn($validEmail);
            $mock->shouldReceive('getAttribute')
                ->with('password')
                ->andReturn(Hash::make($validPassword));
            $mock->shouldReceive('createToken')
                ->andReturn(new NewAccessToken(new PersonalAccessToken(), 'valid_token'));
            $mock->shouldReceive('setAttribute');
        });
        $this->repository->shouldReceive('getByEmail')
            ->andReturn($user);

        // Act
        $result = $this->useCase->handle($validEmail, $validPassword);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group users
     * @test
    */
    public function shouldThrowUserNotFoundWhenInvalidEmailProvided()
    {
        // Arrange
        $invalidEmail = 'invalid@mail.com';
        $validPassword = '12345678';

        $this->repository->shouldReceive('getByEmail')
            ->andReturn(null);

        try {
            // Act
            $this->useCase->handle($invalidEmail, $validPassword);
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(UserNotFound::class, $th);
        }
    }

    /**
     * @group users
     * @test
    */
    public function shouldThrowUserBadCredentialsWhenInvalidPasswordProvided()
    {
        // Arrange
        $validEmail = 'admin@mail.com';
        $validPassword = '12345678';
        $invalidPassword = 'invalid_password';
        $user = Mockery::mock(User::class, function ($mock) use ($validEmail, $validPassword) {
            $mock->shouldReceive('getAttribute')
                ->with('email')
                ->andReturn($validEmail);
            $mock->shouldReceive('getAttribute')
                ->with('password')
                ->andReturn(Hash::make($validPassword));
            $mock->shouldReceive('createToken')
                ->andReturn(new NewAccessToken(new PersonalAccessToken(), 'valid_token'));
        });

        $this->repository->shouldReceive('getByEmail')
            ->andReturn($user);

        try {
            // Act
            $this->useCase->handle($validEmail, $invalidPassword);
        } catch (\Throwable $th) {
            // Assert
            $this->assertInstanceOf(UserBadCredentials::class, $th);
        }
    }
}

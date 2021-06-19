<?php

namespace Tests\Feature\User\Domain;

use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;
use Features\User\Domain\Usecases\SendTemporalPasswordUseCase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class SendTemporalPasswordUseCaseTest extends TestCase
{
    /**
     * @var UserRepository|LegacyMockInterface
     */
    private $repository;

    private SendTemporalPasswordUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserRepository::class);
        $this->useCase = new SendTemporalPasswordUseCase($this->repository);
    }

    /**
     * @group users
     * @test
    */
    public function shouldUpdatePasswordAndSendItWhenValidAttributesProvided()
    {
        // Arrange
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn("jasdhkjasdh");
            $mock->shouldReceive('getAttribute')
                ->with('password')
                ->andReturn(Hash::make('12345678'));
            $mock->shouldReceive('setAttribute');
        });
        $email = "fake@mail.com";
        $this->repository->shouldReceive('getByEmail')
            ->andReturn($user);
        $this->repository->shouldReceive('update')
            ->andReturn($user);

        // Act
        $result = $this->useCase->handle($email);

        // Assert
        $this->assertNotNull($result);
    }
}

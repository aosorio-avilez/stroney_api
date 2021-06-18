<?php

namespace Tests\Feature\User\Domain;

use Features\User\Domain\Repositories\UserRepository;
use Features\User\Domain\Usecases\UpdateUserUseCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class UpdateUserUseCaseTest extends TestCase
{
    /**
     * @var UserRepository|LegacyMockInterface
     */
    private $repository;

    private UpdateUserUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var UserRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(UserRepository::class);
        $this->useCase = new UpdateUserUseCase($this->repository);
    }

    /**
     * @group users
     * @test
    */
    public function shouldUpdateUserWhenValidAttributesProvided()
    {
        // Arrange
        Storage::fake('testing');
        /**
         * @var User
         */
        $user = Mockery::mock(User::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn("jasdhkjasdh");
            $mock->shouldReceive('getAttribute')
                ->with('image_file_name')
                ->andReturn("name.jpg");
            $mock->shouldReceive('setAttribute');
        });
        $image = UploadedFile::fake()->create('test.jpg');
        $this->repository->shouldReceive('getById')
            ->andReturn($user);
        $this->repository->shouldReceive('update')
            ->andReturn($user);

        // Act
        $result = $this->useCase->handle(
            $user->id,
            $user,
            $image
        );

        // Assert
        $this->assertNotNull($result);
        $this->assertNotEmpty(Storage::disk('testing')->allFiles());
    }
}

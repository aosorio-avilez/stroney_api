<?php

namespace Tests\Feature\User\Data;

use Features\User\Data\Repositories\UserRepositoryImpl;
use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private UserRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserRepositoryImpl();
    }

    /**
     * @group users
     * @test
    */
    public function getUserByEmailShouldReturnUserWhenValidEmailProvided()
    {
        // Arrange
        $validEmail = 'test@mail.com';
        User::factory()->create([
            'email' => $validEmail
        ]);

        // Act
        $result = $this->repository->getByEmail($validEmail);

        // Assert
        $this->assertNotNull($result);
        $this->assertEquals($validEmail, $result->email);
    }

    /**
     * @group users
     * @test
    */
    public function getUserByEmailShouldReturnNullWhenInvalidEmailProvided()
    {
        // Arrange
        $invalidEmail = 'invalid@mail.com';

        // Act
        $result = $this->repository->getByEmail($invalidEmail);

        // Assert
        $this->assertNull($result);
    }

    /**
     * @group users
     * @test
    */
    public function createShouldPersistUserInDatabase()
    {
        // Arrange
        $user = User::factory()->make();

        // Act
        $result = $this->repository->create($user);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('users', [
            'name' => $result->name,
            'email' => $result->email,
        ]);
    }

    /**
     * @group users
     * @test
    */
    public function findByIdShouldReturnUserInDatabase()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $result = $this->repository->getById($user->id);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group users
     * @test
    */
    public function updateShouldUpdateUserInDatabase()
    {
        // Arrange
        $userToUpdate = User::factory()->create();
        $user = User::factory()->make();

        // Act
        $result = $this->repository->update($userToUpdate->id, $user);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => $result->name,
            'email' => $result->email,
            'image_url' => $result->image_url,
            'image_file_name' => $result->image_file_name,
        ]);
    }
}

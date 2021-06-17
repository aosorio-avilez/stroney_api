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
}

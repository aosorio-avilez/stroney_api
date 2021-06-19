<?php

namespace Tests\Feature\User\Data;

use App\Models\Category;
use App\Models\User;
use Features\Category\Data\Repositories\CategoryRepositoryImpl;
use Features\Category\Domain\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private CategoryRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new CategoryRepositoryImpl();
    }

    /**
     * @group categories
     * @test
    */
    public function createShouldPersistUserInDatabase()
    {
        // Arrange
        $category = Category::factory()->make();

        // Act
        $result = $this->repository->create($category);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('categories', [
            'user_id' => $result->user_id,
            'name' => $result->name,
        ]);
    }
}

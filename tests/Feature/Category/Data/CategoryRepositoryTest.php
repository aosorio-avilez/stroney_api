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

    /**
     * @group categories
     * @test
    */
    public function updateShouldUpdateCategoryInDatabase()
    {
        // Arrange
        $categoryToUpdate = Category::factory()->create();
        $category = Category::factory()->make();

        // Act
        $result = $this->repository->update($categoryToUpdate->id, $category);

        // Assert
        $this->assertNotNull($result);
        $this->assertDatabaseHas('categories', [
            'id' => $categoryToUpdate->id,
            'name' => $result->name,
        ]);
    }

    /**
     * @group categories
     * @test
    */
    public function getByIdShouldReturnCategoryFromDatabase()
    {
        // Arrange
        $category = Category::factory()->create();

        // Act
        $result = $this->repository->getById($category->id);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group categories
     * @test
    */
    public function removeShouldDeleteCategoryFromDatabase()
    {
        // Arrange
        $category = Category::factory()->create();

        // Act
        $result = $this->repository->remove($category->id);

        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
        ]);
    }

    /**
     * @group categories
     * @test
    */
    public function getByUserShouldReturnUserCategoriesFromDatabase()
    {
        // Arrange
        $user = User::factory()->create();
        Category::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id
            ]);

        // Act
        $result = $this->repository->getByUser($user->id);

        // Assert
        $this->assertNotNull($result);
        $this->assertNotEmpty($result);
        $this->assertCount(10, $result);
    }
}

<?php

namespace Tests\Feature\Category\Domain;

use App\Models\Category;
use Features\Category\Domain\Failures\CategoryNotFound;
use Features\Category\Domain\Repositories\CategoryRepository;
use Features\Category\Domain\Usecases\GetCategoryUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetCategoryUseCaseTest extends TestCase
{
    /**
     * @var CategoryRepository|LegacyMockInterface
     */
    private $repository;

    private GetCategoryUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var CategoryRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(CategoryRepository::class);
        $this->useCase = new GetCategoryUseCase($this->repository);
    }

    /**
     * @group categories
     * @test
    */
    public function shouldReturnCategoryWhenValidIdProvided()
    {
        // Arrange
        $categoryId = Uuid::uuid1()->toString();
        /**
         * @var Category
         */
        $category = Mockery::mock(Category::class, function ($mock) use ($categoryId) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn($categoryId);
        });
        $this->repository->shouldReceive('getById')
            ->andReturn($category);

        // Act
        $result = $this->useCase->handle($category->id);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @group categories
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
            $this->assertInstanceOf(CategoryNotFound::class, $th);
        }
    }
}

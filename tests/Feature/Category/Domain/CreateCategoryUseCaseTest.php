<?php

namespace Tests\Feature\Category\Domain;

use App\Models\Category;
use Features\Category\Domain\Repositories\CategoryRepository;
use Features\Category\Domain\Usecases\CreateCategoryUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class CreateCategoryUseCaseTest extends TestCase
{
    /**
     * @var CategoryRepository|LegacyMockInterface
     */
    private $repository;

    private CreateCategoryUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var CategoryRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(CategoryRepository::class);
        $this->useCase = new CreateCategoryUseCase($this->repository);
    }

    /**
     * @group categories
     * @test
    */
    public function shouldCreateCategoryWhenValidAttributesProvided()
    {
        // Arrange
        /**
         * @var Category
         */
        $category = Mockery::mock(Category::class);
        $this->repository->shouldReceive('create')
            ->andReturn($category);

        // Act
        $result = $this->useCase->handle($category);

        // Assert
        $this->assertNotNull($result);
    }
}

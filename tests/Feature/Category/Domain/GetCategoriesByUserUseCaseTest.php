<?php

namespace Tests\Feature\Category\Domain;

use App\Models\Category;
use Features\Category\Domain\Failures\CategoryNotFound;
use Features\Category\Domain\Repositories\CategoryRepository;
use Features\Category\Domain\Usecases\GetCategoriesByUserUseCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetCategoriesByUserUseCaseTest extends TestCase
{
    /**
     * @var CategoryRepository|LegacyMockInterface
     */
    private $repository;

    private GetCategoriesByUserUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var CategoryRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(CategoryRepository::class);
        $this->useCase = new GetCategoriesByUserUseCase($this->repository);
    }

    /**
     * @group categories
     * @test
    */
    public function shouldReturnCategories()
    {
        // Arrange
        $userId = Uuid::uuid1()->toString();
        $category = Mockery::mock(Category::class);
        $this->repository->shouldReceive('getByUser')
            ->andReturn(new Collection([$category]));

        // Act
        $result = $this->useCase->handle($userId);

        // Assert
        $this->assertNotEmpty($result);
    }
}

<?php

namespace Tests\Feature\Category\Domain;

use App\Models\Category;
use Features\User\Domain\Repositories\UserRepository;
use Features\User\Domain\Usecases\UpdateUserUseCase;
use App\Models\User;
use Features\Category\Domain\Repositories\CategoryRepository;
use Features\Category\Domain\Usecases\UpdateCategoryUseCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UpdateCategoryUseCaseTest extends TestCase
{
    /**
     * @var CategoryRepository|LegacyMockInterface
     */
    private $repository;

    private UpdateCategoryUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var CategoryRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(CategoryRepository::class);
        $this->useCase = new UpdateCategoryUseCase($this->repository);
    }

    /**
     * @group categories
     * @test
    */
    public function shouldUpdateCategoryWhenValidAttributesProvided()
    {
        // Arrange
        $categoryId = Uuid::uuid1()->toString();
        /**
         * @var Category
         */
        $category = Mockery::mock(Category::class, function ($mock) {
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn("jasdhkjasdh");
        });
        $this->repository->shouldReceive('update')
            ->andReturn($category);

        // Act
        $result = $this->useCase->handle($categoryId, $category);

        // Assert
        $this->assertNotNull($result);
    }
}

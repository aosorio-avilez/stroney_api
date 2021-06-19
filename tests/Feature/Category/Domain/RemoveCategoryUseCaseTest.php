<?php

namespace Tests\Feature\Category\Domain;

use Features\Category\Domain\Repositories\CategoryRepository;
use Features\Category\Domain\Usecases\RemoveCategoryUseCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class RemoveCategoryUseCaseTest extends TestCase
{
    /**
     * @var CategoryRepository|LegacyMockInterface
     */
    private $repository;

    private RemoveCategoryUseCase $useCase;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var CategoryRepository|LegacyMockInterface
         */
        $this->repository = Mockery::mock(CategoryRepository::class);
        $this->useCase = new RemoveCategoryUseCase($this->repository);
    }

    /**
     * @group categories
     * @test
    */
    public function shouldRemoveCategory()
    {
        // Arrange
        $categoryId = Uuid::uuid1()->toString();
        $this->repository->shouldReceive('remove')
            ->andReturn(true);

        // Act
        $result = $this->useCase->handle($categoryId);

        // Assert
        $this->assertTrue($result);
    }
}

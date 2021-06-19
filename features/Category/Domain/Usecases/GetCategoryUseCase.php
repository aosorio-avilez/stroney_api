<?php

namespace Features\Category\Domain\Usecases;

use App\Models\Category;
use Features\Category\Domain\Failures\CategoryNotFound;
use Features\Category\Domain\Repositories\CategoryRepository;

class GetCategoryUseCase
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $categoryId): Category
    {
        $category =  $this->repository->getById($categoryId);

        if ($category == null) {
            throw new CategoryNotFound();
        }

        return $category;
    }
}

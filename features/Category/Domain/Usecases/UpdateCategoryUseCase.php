<?php

namespace Features\Category\Domain\Usecases;

use App\Models\Category;
use Features\Category\Domain\Repositories\CategoryRepository;

class UpdateCategoryUseCase
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $categoryId, Category $category): Category
    {
        return $this->repository->update($categoryId, $category);
    }
}

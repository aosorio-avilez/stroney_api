<?php

namespace Features\Category\Domain\Usecases;

use App\Models\Category;
use Features\Category\Domain\Repositories\CategoryRepository;

class CreateCategoryUseCase
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Category $category): Category
    {
        return $this->repository->create($category);
    }
}

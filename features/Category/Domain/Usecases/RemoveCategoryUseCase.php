<?php

namespace Features\Category\Domain\Usecases;

use Features\Category\Domain\Repositories\CategoryRepository;

class RemoveCategoryUseCase
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $categoryId): bool
    {
        return $this->repository->remove($categoryId);
    }
}

<?php

namespace Features\Category\Domain\Usecases;

use Features\Category\Domain\Repositories\CategoryRepository;

class GetCategoriesByUserUseCase
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userId): array
    {
        return $this->repository->getByUser($userId)->all();
    }
}

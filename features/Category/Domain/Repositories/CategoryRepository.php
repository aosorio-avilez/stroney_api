<?php

namespace Features\Category\Domain\Repositories;

use App\Models\Category;
use Illuminate\Support\Enumerable;

interface CategoryRepository
{
    public function create(Category $category): Category;
    
    public function getById(string $categoryId): ?Category;
    
    public function update(string $categoryId, Category $category): Category;
    
    public function remove(string $categoryId): bool;

    public function getByUser(string $userId): Enumerable;
}

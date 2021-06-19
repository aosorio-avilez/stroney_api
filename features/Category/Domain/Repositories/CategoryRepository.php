<?php

namespace Features\Category\Domain\Repositories;

use App\Models\Category;

interface CategoryRepository
{
    public function create(Category $category): Category;
    
    public function getById(string $categoryId): ?Category;
    
    public function update(string $categoryId, Category $category): Category;
    
    public function remove(string $categoryId): bool;
}

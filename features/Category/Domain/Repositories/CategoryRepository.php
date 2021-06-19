<?php

namespace Features\Category\Domain\Repositories;

use App\Models\Category;

interface CategoryRepository
{
    public function create(Category $category): Category;
}

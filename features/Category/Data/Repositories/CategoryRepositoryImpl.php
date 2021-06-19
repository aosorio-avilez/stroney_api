<?php

namespace Features\Category\Data\Repositories;

use App\Models\Category;
use Features\Category\Domain\Repositories\CategoryRepository;
use Features\Core\Framework\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CategoryRepositoryImpl extends BaseRepository implements CategoryRepository
{
    public function getModel(): Model
    {
        $model = Category::class;
        return new $model;
    }

    public function create(Category $category): Category
    {
        return $this->createOrUpdate($category->getAttributes());
    }

    public function update(string $categoryId, Category $category): Category
    {
        return $this->createOrUpdate($category->getAttributes(), [
            'id' => $categoryId
        ]);
    }

    public function getById(string $categoryId): ?Category
    {
        return $this->newQuery()
            ->where('id', $categoryId)
            ->first();
    }
}

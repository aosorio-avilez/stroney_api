<?php

namespace App\Features\Core\Framework\Base;

use App\Features\Core\Domain\Repository\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements Repository
{
    public function find(int $id, array $relations = null): ?Model
    {
        $model = $this->getModel();

        if ($relations != null) {
            $model = $model->with($relations);
        }

        return $model->find($id);
    }

    public function newQuery(): Builder
    {
        return $this->getModel()->newQuery();
    }

    public function createOrUpdate(array $attributes, ?array $identifiers = null): Model
    {
        $model = $this->getModel();

        if ($identifiers == null) {
            return $model->create($attributes);
        }
        
        return $model->updateOrCreate($identifiers, $attributes);
    }

    public function delete(int $id): bool
    {
        $model = $this->getModel();

        return $model
            ->find($id)
            ->delete();
    }
}

<?php

namespace App\Features\Core\Framework\Helper;

use Illuminate\Database\Eloquent\Model;

trait WithTrash
{
    public function findInTrash(int $id, array $relations = null): ?Model
    {
        $model = $this->getModel();

        if ($relations != null) {
            $model = $model->with($relations);
        }

        return $model
            ->withTrashed()
            ->find($id);
    }

    public function restore(int $id): bool
    {
        $model = $this->getModel();

        return $model
            ->withTrashed()
            ->find($id)
            ->restore();
    }
}

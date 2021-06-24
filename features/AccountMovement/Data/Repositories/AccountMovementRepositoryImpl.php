<?php

namespace Features\AccountMovement\Data\Repositories;

use App\Models\AccountMovement;
use Features\AccountMovement\Domain\Repositories\AccountMovementRepository;
use Features\Core\Framework\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class AccountMovementRepositoryImpl extends BaseRepository implements AccountMovementRepository
{
    public function getModel(): Model
    {
        $model = AccountMovement::class;
        return new $model;
    }

    public function create(AccountMovement $accountMovement): AccountMovement
    {
        return $this->createOrUpdate($accountMovement->getAttributes());
    }
}

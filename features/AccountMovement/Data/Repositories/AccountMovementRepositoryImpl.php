<?php

namespace Features\AccountMovement\Data\Repositories;

use App\Models\AccountMovement;
use Features\AccountMovement\Domain\Repositories\AccountMovementRepository;
use Features\Core\Framework\Base\BaseRepository;
use Features\Core\Framework\Helper\Paginable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Enumerable;

class AccountMovementRepositoryImpl extends BaseRepository implements AccountMovementRepository
{
    use Paginable;

    public function getModel(): Model
    {
        $model = AccountMovement::class;
        return new $model;
    }

    public function create(AccountMovement $accountMovement): AccountMovement
    {
        return $this->createOrUpdate($accountMovement->getAttributes());
    }
    
    public function getByAccount(string $accountId): Enumerable
    {
        return $this->newQuery()
            ->where('account_id', $accountId)
            ->get();
    }
}

<?php

namespace Features\Account\Data\Repositories;

use App\Models\Account;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\Core\Framework\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class AccountRepositoryImpl extends BaseRepository implements AccountRepository
{
    public function getModel(): Model
    {
        $model = Account::class;
        return new $model;
    }

    public function create(Account $account): Account
    {
        return $this->createOrUpdate($account->getAttributes());
    }
}
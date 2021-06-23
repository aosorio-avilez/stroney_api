<?php

namespace Features\Account\Data\Repositories;

use App\Models\Account;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\Core\Framework\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Enumerable;

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

    public function update(string $accountId, Account $account): Account
    {
        return $this->createOrUpdate($account->getAttributes(), [
            'id' => $accountId
        ]);
    }

    public function getById(string $accountId): ?Account
    {
        return $this->newQuery()
            ->where('id', $accountId)
            ->first();
    }

    public function remove(string $accountId): bool
    {
        return $this->newQuery()
            ->where('id', $accountId)
            ->first()
            ->delete();
    }

    public function getByUser(string $userId): Enumerable
    {
        return $this->newQuery()
            ->where('user_id', $userId)
            ->get();
    }
}

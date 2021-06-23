<?php

namespace Features\UserCurrency\Data\Repositories;

use Features\Core\Framework\Base\BaseRepository;

use App\Models\UserCurrency;
use Features\UserCurrency\Domain\Repositories\UserCurrencyRepository;
use Illuminate\Database\Eloquent\Model;

class UserCurrencyRepositoryImpl extends BaseRepository implements UserCurrencyRepository
{
    public function getModel(): Model
    {
        $model = UserCurrency::class;
        return new $model;
    }

    public function create(UserCurrency $userCurrrency): UserCurrency
    {
        return $this->createOrUpdate($userCurrrency->getAttributes());
    }

    public function getByCurrency(string $userId, string $currencyId): ?UserCurrency
    {
        return $this->newQuery()
            ->where('user_id', $userId)
            ->where('currency_id', $currencyId)
            ->first();
    }

    public function getById(string $userCurrencyId): ?UserCurrency
    {
        return $this->newQuery()
            ->where('id', $userCurrencyId)
            ->first();
    }

    public function update(string $userCurrencyId, UserCurrency $userCurrency): UserCurrency
    {
        return $this->createOrUpdate($userCurrency->getAttributes(), [
            'id' => $userCurrencyId
        ]);
    }
 
    public function remove(string $userCurrencyId): bool
    {
        return $this->newQuery()
            ->where('id', $userCurrencyId)
            ->first()
            ->delete();
    }
}

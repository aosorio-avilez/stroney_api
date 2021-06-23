<?php

namespace Features\User\Data\Repositories;

use Features\Core\Framework\Base\BaseRepository;

use App\Models\UserCurrency;
use Features\User\Domain\Repositories\UserCurrencyRepository;
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
}

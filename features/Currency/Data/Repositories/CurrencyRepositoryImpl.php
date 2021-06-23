<?php

namespace Features\Currency\Data\Repositories;

use App\Models\Currency;
use Features\Core\Framework\Base\BaseRepository;
use Features\Currency\Domain\Repositories\CurrencyRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Enumerable;

class CurrencyRepositoryImpl extends BaseRepository implements CurrencyRepository
{
    public function getModel(): Model
    {
        $model = Currency::class;
        return new $model;
    }

    public function getCurrencies(): Enumerable
    {
        return $this->newQuery()
            ->get();
    }
}

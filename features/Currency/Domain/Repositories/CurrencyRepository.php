<?php

namespace Features\Currency\Domain\Repositories;

use App\Models\Currency;
use Illuminate\Support\Enumerable;

interface CurrencyRepository
{
    public function getCurrencies(): Enumerable;

    public function getById(string $currencyId): ?Currency;
}

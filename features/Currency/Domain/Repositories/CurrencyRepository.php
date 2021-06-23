<?php

namespace Features\Currency\Domain\Repositories;

use Illuminate\Support\Enumerable;

interface CurrencyRepository
{
    public function getCurrencies(): Enumerable;
}

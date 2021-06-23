<?php

namespace Features\Currency\Presentation\Transformers;

use App\Models\Currency;
use League\Fractal\TransformerAbstract;

class CurrencyTransformer extends TransformerAbstract
{
    public function transform(Currency $currency)
    {
        return [
            'id' => $currency->id,
            'code' => $currency->code,
            'name' => $currency->name,
            'exchange_rate' => $currency->exchange_rate,
        ];
    }
}

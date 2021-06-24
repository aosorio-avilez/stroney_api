<?php

namespace Features\UserCurrency\Presentation\Transformers;

use App\Models\UserCurrency;
use Features\Core\Framework\Transformer\FractalTransformer;
use Features\Currency\Presentation\Transformers\CurrencyTransformer;
use League\Fractal\TransformerAbstract;

class UserCurrencyTransformer extends TransformerAbstract
{
    private FractalTransformer $fractal;

    public function __construct(
        FractalTransformer $fractal
    ) {
        $this->fractal = $fractal;
    }
    
    public function transform(UserCurrency $userCurrency)
    {
        return [
            'id' => $userCurrency->id,
            'currency' => $this->fractal->makeItem(
                $userCurrency->currency,
                new CurrencyTransformer,
                null
            ),
            'base_exchange_rate' => $userCurrency->base_exchange_rate,
            'exchange_rate' => $userCurrency->exchange_rate,
        ];
    }
}

<?php

namespace Features\Account\Presentation\Transformers;

use App\Models\Account;
use Features\Core\Framework\Transformer\FractalTransformer;
use Features\UserCurrency\Presentation\Transformers\UserCurrencyTransformer;
use League\Fractal\TransformerAbstract;

class AccountTransformer extends TransformerAbstract
{
    private FractalTransformer $fractal;

    public function __construct(
        FractalTransformer $fractal
    ) {
        $this->fractal = $fractal;
    }
    
    public function transform(Account $account)
    {
        return [
            'id' => $account->id,
            'user_currency' => $this->fractal->makeItem(
                $account->userCurrency,
                new UserCurrencyTransformer($this->fractal),
                null
            ),
            'name' => $account->name,
            'amount' => $account->amount,
            'notes' => $account->notes,
        ];
    }
}

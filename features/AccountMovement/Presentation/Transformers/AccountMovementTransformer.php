<?php

namespace Features\AccountMovement\Presentation\Transformers;

use App\Models\AccountMovement;
use Features\Account\Presentation\Transformers\AccountTransformer;
use Features\AccountMovement\Data\Models\MovementType;
use Features\Category\Presentation\Transformers\CategoryTransformer;
use Features\Core\Framework\Transformer\FractalTransformer;
use League\Fractal\TransformerAbstract;

class AccountMovementTransformer extends TransformerAbstract
{
    private FractalTransformer $fractal;

    public function __construct(
        FractalTransformer $fractal
    ) {
        $this->fractal = $fractal;
    }
    
    public function transform(AccountMovement $accountMovement)
    {
        return [
            'account' => $this->fractal->makeItem(
                $accountMovement->account,
                new AccountTransformer($this->fractal),
                null
            ),
            'destination_account' => $accountMovement->destinationAccount != null
                ? $this->fractal->makeItem(
                    $accountMovement->account,
                    new AccountTransformer($this->fractal),
                    null
                ) : null,
            'category' => $accountMovement->category != null
                ? $this->fractal->makeItem(
                    $accountMovement->category,
                    new CategoryTransformer,
                    null
                ): null,
            'amount' => $accountMovement->amount,
            'movement_type' => MovementType::toValue($accountMovement->movement_type),
            'created_date' => $accountMovement->created_date,
            'created_time' => $accountMovement->created_time,
            'notes' => $accountMovement->notes,
        ];
    }
}

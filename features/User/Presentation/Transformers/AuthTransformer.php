<?php

namespace Features\User\Presentation\Transformers;

use Features\Core\Framework\Transformer\FractalTransformer;
use Features\User\Domain\Entities\Auth;
use League\Fractal\TransformerAbstract;

class AuthTransformer extends TransformerAbstract
{
    private FractalTransformer $fractal;

    public function __construct(
        FractalTransformer $fractal
    ) {
        $this->fractal = $fractal;
    }

    public function transform(Auth $auth)
    {
        return [
            'user' => $this->fractal->makeItem($auth->user, new UserTransformer, null),
            'token' => $auth->token,
        ];
    }
}

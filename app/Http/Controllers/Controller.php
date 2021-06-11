<?php

namespace App\Http\Controllers;

use App\Features\Core\Framework\Transformer\FractalTransformer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected FractalTransformer $fractal;

    public function __construct(FractalTransformer $fractal)
    {
        $this->fractal = $fractal;
    }
}

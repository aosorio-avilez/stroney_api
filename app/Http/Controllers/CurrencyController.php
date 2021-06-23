<?php

namespace App\Http\Controllers;

use Features\Currency\Domain\Usecases\GetCurrenciesUseCase;
use Features\Currency\Presentation\Transformers\CurrencyTransformer;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    public function all(
        GetCurrenciesUseCase $getCurrenciesUseCase,
        CurrencyTransformer $currencyTransformer
    ): JsonResponse {
        $currencies = $getCurrenciesUseCase->handle();

        $resource = $this->fractal->makeCollection($currencies, $currencyTransformer);

        return jsonResponse(200, $resource->toArray());
    }
}

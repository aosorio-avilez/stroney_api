<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Features\Account\Domain\Usecases\CreateAccountUseCase;
use Features\Account\Presentation\Transformers\AccountTransformer;
use Features\Account\Presentation\Validators\CreateAccountValidator;
use Features\User\Domain\Usecases\GetUserUseCase;
use Features\UserCurrency\Domain\Usecases\GetUserCurrencyUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function create(
        Request $request,
        CreateAccountValidator $createAccountValidator,
        GetUserUseCase $getUserUseCase,
        GetUserCurrencyUseCase $getUserCurrencyUseCase,
        CreateAccountUseCase $createAccountUseCase,
        AccountTransformer $accountTransformer
    ): JsonResponse {
        $attributes = $createAccountValidator->validate($request->all());

        $getUserUseCase->handle($attributes['user_id']);
        $getUserCurrencyUseCase->handle($attributes['user_currency_id']);

        $account = new Account($attributes);
        $account = $createAccountUseCase->handle($account);

        $resource = $this->fractal->makeItem($account, $accountTransformer);

        return jsonResponse(201, $resource->toArray());
    }
}

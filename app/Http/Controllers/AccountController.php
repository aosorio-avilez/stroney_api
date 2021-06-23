<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Features\Account\Domain\Usecases\CreateAccountUseCase;
use Features\Account\Domain\Usecases\GetAccountUseCase;
use Features\Account\Domain\Usecases\RemoveAccountUseCase;
use Features\Account\Domain\Usecases\UpdateAccountUseCase;
use Features\Account\Presentation\Transformers\AccountTransformer;
use Features\Account\Presentation\Validators\AdjustBalanceAccountValidator;
use Features\Account\Presentation\Validators\CreateAccountValidator;
use Features\Account\Presentation\Validators\UpdateAccountValidator;
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

    public function update(
        string $accountId,
        Request $request,
        UpdateAccountValidator $updateAccountValidator,
        GetAccountUseCase $getAccountUseCase,
        UpdateAccountUseCase $updateAccountUseCase,
        AccountTransformer $accountTransformer
    ): JsonResponse {
        $attributes = $updateAccountValidator->validate($request->all());

        $getAccountUseCase->handle($accountId);

        $account = new Account($attributes);
        $account = $updateAccountUseCase->handle($accountId, $account);

        $resource = $this->fractal->makeItem($account, $accountTransformer);

        return jsonResponse(200, $resource->toArray());
    }

    public function remove(
        string $accountId,
        GetAccountUseCase $getAccountUseCase,
        RemoveAccountUseCase $removeAccountUseCase
    ): JsonResponse {
        $account = $getAccountUseCase->handle($accountId);

        $removeAccountUseCase->handle($account->id);

        return jsonResponse(204);
    }

    public function adjustBalance(
        string $accountId,
        Request $request,
        AdjustBalanceAccountValidator $adjustBalanceAccountValidator,
        GetAccountUseCase $getAccountUseCase,
        UpdateAccountUseCase $updateAccountUseCase,
        AccountTransformer $accountTransformer
    ): JsonResponse {
        $attributes = $adjustBalanceAccountValidator->validate($request->all());

        $account = $getAccountUseCase->handle($accountId);
        $account->amount = $attributes['amount'];

        $account = $updateAccountUseCase->handle($account->id, $account);

        $resource = $this->fractal->makeItem($account, $accountTransformer);

        return jsonResponse(200, $resource->toArray());
    }

    public function get(
        string $accountId,
        GetAccountUseCase $getAccountUseCase,
        AccountTransformer $accountTransformer
    ): JsonResponse {
        $account = $getAccountUseCase->handle($accountId);

        $resource = $this->fractal->makeItem($account, $accountTransformer);

        return jsonResponse(200, $resource->toArray());
    }
}

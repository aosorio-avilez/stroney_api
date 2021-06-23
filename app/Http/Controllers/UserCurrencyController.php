<?php

namespace App\Http\Controllers;

use App\Models\UserCurrency;
use Features\UserCurrency\Domain\Usecases\CreateUserCurrencyUseCase;
use Features\UserCurrency\Domain\Usecases\GetUserCurrencyUseCase;
use Features\User\Domain\Usecases\GetUserUseCase;
use Features\UserCurrency\Domain\Usecases\GetUserCurrenciesByUserUseCase;
use Features\UserCurrency\Domain\Usecases\RemoveUserCurrencyUseCase;
use Features\UserCurrency\Domain\Usecases\UpdateUserCurrencyUseCase;
use Features\UserCurrency\Presentation\Transformers\UserCurrencyTransformer;
use Features\UserCurrency\Presentation\Validators\CreateUserCurrencyValidator;
use Features\UserCurrency\Presentation\Validators\UpdateUserCurrencyValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCurrencyController extends Controller
{
    public function create(
        string $userId,
        Request $request,
        CreateUserCurrencyValidator $createUserCurrencyValidator,
        GetUserUseCase $getUserUseCase,
        CreateUserCurrencyUseCase $createUserCurrencyUseCase,
        UserCurrencyTransformer $userCurrencyTransformer
    ): JsonResponse {
        $attributes = $createUserCurrencyValidator->validate($request->all());

        $user = $getUserUseCase->handle($userId);

        $userCurrency = new UserCurrency($attributes);

        $userCurrency = $createUserCurrencyUseCase->handle(
            $user->id,
            $userCurrency,
        );

        $resource = $this->fractal->makeItem(
            $userCurrency,
            $userCurrencyTransformer
        );

        return jsonResponse(201, $resource->toArray());
    }

    public function update(
        string $userId,
        string $userCurrencyId,
        Request $request,
        UpdateUserCurrencyValidator $updateUserCurrencyValidator,
        GetUserUseCase $getUserUseCase,
        GetUserCurrencyUseCase $getUserCurrencyUseCase,
        UpdateUserCurrencyUseCase $updateUserCurrencyUseCase,
        UserCurrencyTransformer $userCurrencyTransformer
    ): JsonResponse {
        $attributes = $updateUserCurrencyValidator->validate($request->all());

        $getUserUseCase->handle($userId);
        $getUserCurrencyUseCase->handle($userCurrencyId);

        $userCurrency = new UserCurrency($attributes);
        $userCurrency = $updateUserCurrencyUseCase->handle(
            $userCurrencyId,
            $userCurrency,
        );

        $resource = $this->fractal->makeItem(
            $userCurrency,
            $userCurrencyTransformer
        );

        return jsonResponse(200, $resource->toArray());
    }

    public function remove(
        string $userId,
        string $userCurrencyId,
        GetUserUseCase $getUserUseCase,
        GetUserCurrencyUseCase $getUserCurrencyUseCase,
        RemoveUserCurrencyUseCase $removeUserCurrencyUseCase
    ): JsonResponse {
        $getUserUseCase->handle($userId);
        $userCurrency = $getUserCurrencyUseCase->handle($userCurrencyId);

        $removeUserCurrencyUseCase->handle($userCurrency->id);

        return jsonResponse(204);
    }

    public function all(
        string $userId,
        GetUserUseCase $getUserUseCase,
        GetUserCurrenciesByUserUseCase $getUserCurrenciesByUserUseCase,
        UserCurrencyTransformer $userCurrencyTransformer
    ): JsonResponse {
        $user = $getUserUseCase->handle($userId);

        $userCurrencies = $getUserCurrenciesByUserUseCase->handle($user->id);

        $resource = $this->fractal->makeCollection($userCurrencies, $userCurrencyTransformer);

        return jsonResponse(200, $resource->toArray());
    }
}

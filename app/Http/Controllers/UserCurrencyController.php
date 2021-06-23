<?php

namespace App\Http\Controllers;

use App\Models\UserCurrency;
use Features\User\Domain\Usecases\CreateUserCurrencyUseCase;
use Features\User\Domain\Usecases\GetUserUseCase;
use Features\User\Presentation\Transformers\UserCurrencyTransformer;
use Features\User\Presentation\Validators\CreateUserCurrencyValidator;
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
}

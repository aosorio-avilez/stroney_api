<?php

namespace App\Http\Controllers;

use App\Models\AccountMovement;
use Features\Account\Domain\Usecases\GetAccountUseCase;
use Features\AccountMovement\Domain\Usecases\CreateAccountMovementUseCase;
use Features\AccountMovement\Domain\Usecases\GetAccountMovementsByAccountUseCase;
use Features\AccountMovement\Presentation\Transformers\AccountMovementTransformer;
use Features\AccountMovement\Presentation\Validators\CreateAccountMovementValidator;
use Features\Category\Domain\Usecases\GetCategoryUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountMovementController extends Controller
{
    public function create(
        string $accountId,
        Request $request,
        CreateAccountMovementValidator $createAccountMovementValidator,
        GetAccountUseCase $getAccountUseCase,
        GetCategoryUseCase $getCategoryUseCase,
        CreateAccountMovementUseCase $createAccountMovementUseCase,
        AccountMovementTransformer $accountMovementTransformer
    ): JsonResponse {
        $attributes = $createAccountMovementValidator->validate($request->all());

        $account = $getAccountUseCase->handle($accountId);
        
        if ($attributes['category_id'] != null) {
            $getCategoryUseCase->handle($attributes['category_id']);
        }

        if ($attributes['is_transfer']) {
            $getAccountUseCase->handle($attributes['destination_account_id']);
        }

        $accountMovement = new AccountMovement($attributes);
        $accountMovement->account_id = $account->id;
        $accountMovement = $createAccountMovementUseCase->handle(
            $accountMovement,
            $attributes['is_transfer']
        );

        $resource = $this->fractal->makeItem($accountMovement, $accountMovementTransformer);
        
        return jsonResponse(201, $resource->toArray());
    }

    public function all(
        string $accountId,
        GetAccountUseCase $getAccountUseCase,
        GetAccountMovementsByAccountUseCase $getAccountMovementsByAccountUseCase,
        AccountMovementTransformer $accountMovementTransformer
    ): JsonResponse {
        $account = $getAccountUseCase->handle($accountId);

        $movements = $getAccountMovementsByAccountUseCase->handle($account->id);

        $resource = $this->fractal->makePagination(
            $movements,
            $accountMovementTransformer,
            AccountMovement::paginate()
        );

        return jsonResponse(200, $resource->toArray());
    }
}

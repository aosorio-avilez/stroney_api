<?php
namespace App\Http\Controllers;

use App\Models\User;
use Features\Account\Domain\Usecases\GetAccountsByUserUseCase;
use Features\Account\Presentation\Transformers\AccountTransformer;
use Features\Category\Domain\Usecases\GetCategoriesByUserUseCase;
use Features\Category\Presentation\Transformers\CategoryTransformer;
use Features\Envelope\Domain\Usecases\GetEnvelopesByUserUseCase;
use Features\Envelope\Presentation\Transformers\EnvelopeTransformer;
use Features\User\Presentation\Validators\AuthValidator;
use Features\User\Domain\Usecases\AuthenticateUseCase;
use Features\User\Domain\Usecases\CreateUserUseCase;
use Features\User\Domain\Usecases\GetUserUseCase;
use Features\User\Domain\Usecases\SendTemporalPasswordUseCase;
use Features\User\Domain\Usecases\UpdatePasswordUseCase;
use Features\User\Domain\Usecases\UpdateUserUseCase;
use Features\User\Presentation\Transformers\AuthTransformer;
use Features\User\Presentation\Transformers\UserTransformer;
use Features\User\Presentation\Validators\CreateUserValidator;
use Features\User\Presentation\Validators\UpdatePasswordValidator;
use Features\User\Presentation\Validators\UpdateUserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function authenticate(
        Request $request,
        AuthValidator $AuthValidator,
        AuthenticateUseCase $authenticateUseCase,
        AuthTransformer $authTransformer
    ): JsonResponse {
        $attributes = $AuthValidator->validate($request->all());

        $auth = $authenticateUseCase->handle(
            $attributes['email'],
            $attributes['password']
        );

        $resource = $this->fractal->makeItem($auth, $authTransformer);

        return jsonResponse(200, $resource->toArray());
    }

    public function revokeAccess(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return jsonResponse(204);
    }

    public function create(
        Request $request,
        CreateUserValidator $createUserValidator,
        CreateUserUseCase $createUserUseCase,
        UserTransformer $userTransformer
    ): JsonResponse {
        $attributes = $createUserValidator->validate($request->all());

        $user = new User($attributes);
        $user = $createUserUseCase->handle($user);

        $resource = $this->fractal->makeItem($user, $userTransformer);

        return jsonResponse(201, $resource->toArray());
    }

    public function update(
        string $userId,
        Request $request,
        UpdateUserValidator $updateUserValidator,
        GetUserUseCase $getUserUseCase,
        UpdateUserUseCase $updateUserUseCase,
        UserTransformer $userTransformer
    ): JsonResponse {
        $attributes = $updateUserValidator->validate($request->all());

        $user = $getUserUseCase->handle($userId);
        $user->setRawAttributes($attributes);
        $user->setAttribute('id', $userId);

        $image = $attributes['image'] ?? null;
        $user = $updateUserUseCase->handle($user, $image);

        $resource = $this->fractal->makeItem($user, $userTransformer);

        return jsonResponse(200, $resource->toArray());
    }

    public function sendTemporalPassword(
        string $email,
        SendTemporalPasswordUseCase $sendTemporalPasswordUseCase
    ): JsonResponse {
        $sendTemporalPasswordUseCase->handle($email);

        return jsonResponse(204);
    }

    public function updatePassword(
        string $userId,
        Request $request,
        UpdatePasswordValidator $updatePasswordValidator,
        GetUserUseCase $getUserUseCase,
        UpdatePasswordUseCase $updatePasswordUseCase
    ): JsonResponse {
        $attributes = $updatePasswordValidator->validate($request->all());

        $user = $getUserUseCase->handle($userId);

        $updatePasswordUseCase->handle(
            $user,
            $attributes['current_password'],
            $attributes['new_password'],
        );

        return jsonResponse(204);
    }

    public function categories(
        string $userId,
        GetUserUseCase $getUserUseCase,
        GetCategoriesByUserUseCase $getCategoriesByUserUseCase,
        CategoryTransformer $categoryTransformer
    ): JsonResponse {
        $user = $getUserUseCase->handle($userId);

        $categories = $getCategoriesByUserUseCase->handle($user->id);

        $resource = $this->fractal->makeCollection($categories, $categoryTransformer);

        return jsonResponse(200, $resource->toArray());
    }

    public function accounts(
        string $userId,
        GetUserUseCase $getUserUseCase,
        GetAccountsByUserUseCase $getAccountsByUserUseCase,
        AccountTransformer $accountTransformer
    ): JsonResponse {
        $user = $getUserUseCase->handle($userId);

        $accounts = $getAccountsByUserUseCase->handle($user->id);

        $resource = $this->fractal->makeCollection($accounts, $accountTransformer);

        return jsonResponse(200, $resource->toArray());
    }

    public function envelopes(
        string $userId,
        GetUserUseCase $getUserUseCase,
        GetEnvelopesByUserUseCase $getEnvelopesByUserUseCase,
        EnvelopeTransformer $envelopeTransformer
    ): JsonResponse {
        $user = $getUserUseCase->handle($userId);

        $envelopes = $getEnvelopesByUserUseCase->handle($user->id);

        $resource = $this->fractal->makeCollection($envelopes, $envelopeTransformer);

        return jsonResponse(200, $resource->toArray());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Features\User\Presentation\Validators\AuthValidator;
use Features\User\Domain\Usecases\AuthenticateUseCase;
use Features\User\Domain\Usecases\CreateUserUseCase;
use Features\User\Domain\Usecases\SendTemporalPasswordUseCase;
use Features\User\Domain\Usecases\UpdateUserUseCase;
use Features\User\Presentation\Transformers\AuthTransformer;
use Features\User\Presentation\Transformers\UserTransformer;
use Features\User\Presentation\Validators\CreateUserValidator;
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
        UpdateUserUseCase $updateUserUseCase,
        UserTransformer $userTransformer
    ): JsonResponse {
        $attributes = $updateUserValidator->validate($request->all());
        
        $user = new User($attributes);
        $image = $attributes['image'] ?? null;
        $user = $updateUserUseCase->handle($userId, $user, $image);

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
}

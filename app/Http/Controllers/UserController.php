<?php

namespace App\Http\Controllers;

use Features\User\Presentation\Validators\AuthValidator;
use Features\User\Domain\Usecases\AuthenticateUseCase;
use Features\User\Presentation\Transformers\AuthTransformer;
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
}

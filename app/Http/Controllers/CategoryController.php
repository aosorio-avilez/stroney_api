<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Features\Category\Domain\Usecases\CreateCategoryUseCase;
use Features\Category\Presentation\Transformers\CategoryTransformer;
use Features\Category\Presentation\Validators\CreateCategoryValidator;
use Features\User\Domain\Usecases\GetUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(
        string $userId,
        Request $request,
        CreateCategoryValidator $createCategoryValidator,
        GetUserUseCase $getUserUseCase,
        CreateCategoryUseCase $createCategoryUseCase,
        CategoryTransformer $categoryTransformer
    ): JsonResponse {
        $attributes = $createCategoryValidator->validate($request->all());

        $user = $getUserUseCase->handle($userId);
        $attributes['user_id'] = $user->id;

        $category = new Category($attributes);
        $category = $createCategoryUseCase->handle($category);

        $resource = $this->fractal->makeItem($category, $categoryTransformer);

        return jsonResponse(201, $resource->toArray());
    }
}

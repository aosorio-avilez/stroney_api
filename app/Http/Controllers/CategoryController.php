<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Features\Category\Domain\Usecases\CreateCategoryUseCase;
use Features\Category\Domain\Usecases\GetCategoryUseCase;
use Features\Category\Domain\Usecases\RemoveCategoryUseCase;
use Features\Category\Domain\Usecases\UpdateCategoryUseCase;
use Features\Category\Presentation\Transformers\CategoryTransformer;
use Features\Category\Presentation\Validators\CreateOrUpdateCategoryValidator;
use Features\User\Domain\Usecases\GetUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(
        string $userId,
        Request $request,
        CreateOrUpdateCategoryValidator $createCategoryValidator,
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

    public function update(
        string $userId,
        string $categoryId,
        Request $request,
        CreateOrUpdateCategoryValidator $updateCategoryValidator,
        GetUserUseCase $getUserUseCase,
        GetCategoryUseCase $getCategoryUseCase,
        UpdateCategoryUseCase $updateCategoryUseCase,
        CategoryTransformer $categoryTransformer
    ): JsonResponse {
        $attributes = $updateCategoryValidator->validate($request->all());

        $getUserUseCase->handle($userId);

        $category = $getCategoryUseCase->handle($categoryId);
        $category->setRawAttributes($attributes);
        $category = $updateCategoryUseCase->handle($categoryId, $category);

        $resource = $this->fractal->makeItem($category, $categoryTransformer);

        return jsonResponse(200, $resource->toArray());
    }

    public function remove(
        string $userId,
        string $categoryId,
        GetUserUseCase $getUserUseCase,
        GetCategoryUseCase $getCategoryUseCase,
        RemoveCategoryUseCase $removeCategoryUseCase
    ): JsonResponse {
        $getUserUseCase->handle($userId);

        $category = $getCategoryUseCase->handle($categoryId);
        $removeCategoryUseCase->handle($category->id);

        return jsonResponse(204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Features\Category\Domain\Usecases\CreateCategoryUseCase;
use Features\Category\Domain\Usecases\GetCategoryUseCase;
use Features\Category\Domain\Usecases\RemoveCategoryUseCase;
use Features\Category\Domain\Usecases\UpdateCategoryUseCase;
use Features\Category\Presentation\Transformers\CategoryTransformer;
use Features\Category\Presentation\Validators\CreateCategoryValidator;
use Features\Category\Presentation\Validators\UpdateCategoryValidator;
use Features\User\Domain\Usecases\GetUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(
        Request $request,
        CreateCategoryValidator $createCategoryValidator,
        GetUserUseCase $getUserUseCase,
        CreateCategoryUseCase $createCategoryUseCase,
        CategoryTransformer $categoryTransformer
    ): JsonResponse {
        $attributes = $createCategoryValidator->validate($request->all());

        $getUserUseCase->handle($attributes['user_id']);

        $category = new Category($attributes);
        $category = $createCategoryUseCase->handle($category);

        $resource = $this->fractal->makeItem($category, $categoryTransformer);

        return jsonResponse(201, $resource->toArray());
    }

    public function update(
        string $categoryId,
        Request $request,
        UpdateCategoryValidator $updateCategoryValidator,
        GetCategoryUseCase $getCategoryUseCase,
        UpdateCategoryUseCase $updateCategoryUseCase,
        CategoryTransformer $categoryTransformer
    ): JsonResponse {
        $attributes = $updateCategoryValidator->validate($request->all());

        $category = $getCategoryUseCase->handle($categoryId);
        $category->setRawAttributes($attributes);
        $category = $updateCategoryUseCase->handle($categoryId, $category);

        $resource = $this->fractal->makeItem($category, $categoryTransformer);

        return jsonResponse(200, $resource->toArray());
    }

    public function remove(
        string $categoryId,
        GetCategoryUseCase $getCategoryUseCase,
        RemoveCategoryUseCase $removeCategoryUseCase
    ): JsonResponse {
        $category = $getCategoryUseCase->handle($categoryId);

        $removeCategoryUseCase->handle($category->id);

        return jsonResponse(204);
    }

    public function get(
        string $categoryId,
        GetCategoryUseCase $getCategoryUseCase,
        CategoryTransformer $categoryTransformer
    ): JsonResponse {
        $category = $getCategoryUseCase->handle($categoryId);

        $resource = $this->fractal->makeItem($category, $categoryTransformer);

        return jsonResponse(200, $resource->toArray());
    }
}

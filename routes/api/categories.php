<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('', [CategoryController::class, 'create']);

Route::get('/{categoryId}', [CategoryController::class, 'get']);

Route::put('/{categoryId}', [CategoryController::class, 'update']);

Route::delete('/{categoryId}', [CategoryController::class, 'remove']);

<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('', [CategoryController::class, 'create']);

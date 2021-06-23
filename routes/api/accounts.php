<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::post('', [AccountController::class, 'create']);

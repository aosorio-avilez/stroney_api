<?php

use App\Http\Controllers\EnvelopeController;
use Illuminate\Support\Facades\Route;

Route::post('', [EnvelopeController::class, 'create']);

Route::put('{envelopeId}', [EnvelopeController::class, 'update']);

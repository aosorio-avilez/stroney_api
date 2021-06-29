<?php

use App\Http\Controllers\EnvelopeController;
use Illuminate\Support\Facades\Route;

Route::post('', [EnvelopeController::class, 'create']);

Route::put('{envelopeId}', [EnvelopeController::class, 'update']);

Route::delete('{envelopeId}', [EnvelopeController::class, 'remove']);

Route::get('{envelopeId}', [EnvelopeController::class, 'get']);

Route::patch('{envelopeId}/transfer', [EnvelopeController::class, 'transfer']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClienteApiController;

//Route::get('/clientes', [ClienteApiController::class, 'index']);

Route::apiResource('clientes', ClienteApiController::class);
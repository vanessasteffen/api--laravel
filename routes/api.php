<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\DocumentoApiController;
use App\Http\Controllers\Api\TelefoneApiController;
use App\Http\Controllers\Api\FilmeApiController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\FornecedorApiController;




//Route::get('/clientes', [ClienteApiController::class, 'index']);


//Rotas de Login
Route::post('login', [AuthenticateController::class, 'authenticate']);
Route::post('login-refresh', [AuthenticateController::class, 'refreshToken']);
Route::get('me', [AuthenticateController::class, 'getAuthenticatedUser']);


//Route::group(['middleware' => 'auth:api'], 
//function(){
//Rota de clientes
Route::get('clientes/{id}/filmes_alugados', [ClienteApiController::class, 'alugados']);
Route::get('clientes/{id}/documento', [ClienteApiController::class, 'documento']);
Route::get('clientes/{id}/telefone', [ClienteApiController::class, 'telefone']);
Route::apiResource('clientes', ClienteApiController::class);


//rota de documentos
Route::get('documento/{id}/cliente', [DocumentoApiController::class, 'cliente']);
Route::apiResource('documento', DocumentoApiController::class);

//rota de telefones
Route::get('telefone/{id}/cliente', [TelefoneApiController::class, 'cliente']);
Route::apiResource('telefone', TelefoneApiController::class);

//rota de filmes
//Route::get('clientes', [FilmeApiController::class, 'index']);
Route::apiResource('filme', FilmeApiController::class);
Route::apiResource('fornecedores', FornecedorApiController::class);


//});

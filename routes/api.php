<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventosController; //namespace controlador

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/eventos',[EventosController::class,'index']);

Route::get('/eventos/{id}',[EventosController::class,'show']);

Route::post('/eventos',[EventosController::class,'store']);

Route::put('/eventos/{id}',[EventosController::class,'update']);

Route::delete('/eventos/{id}',[EventosController::class,'destroy']);

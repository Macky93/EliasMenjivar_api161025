<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZonaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/zonas',[ZonaController::class,'obtenerZonas']); //plural

Route::get('/zona/{idzona}',[ZonaController::class,'obtenerZona']); //singular

Route::get('/zonaspais/{idpais}',[ZonaController::class,'obtenerZonapais']); //singular

Route::post('/nuevazona',[ZonaController::class,'crearZona']);
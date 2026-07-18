<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\LibroController;
use App\Http\Controllers\Api\AutoriaController;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\SocioController;

// Autores
Route::apiResource('autores', AutorController::class);

// Libros
Route::apiResource('libros', LibroController::class);

// Autorias
Route::apiResource('autorias', AutoriaController::class);

// Reservas
Route::apiResource('reservas', ReservaController::class);

// Socios
Route::apiResource('socios', SocioController::class);
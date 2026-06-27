<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\LibroController;
use App\Http\Controllers\Api\AutoriaController;

// Autores
Route::apiResource('autores', AutorController::class);

// Libros
Route::apiResource('libros', LibroController::class);

// Autorias
Route::apiResource('autorias', AutoriaController::class);
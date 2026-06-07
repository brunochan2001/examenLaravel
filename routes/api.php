<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\LibroController;

// Autores
Route::apiResource('autores', AutorController::class);

// Libros
Route::apiResource('libros', LibroController::class);
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/libros', function(){
    return view('libros.index');
});


Route::get('/autores', function(){
    return view('autores.index');
});


Route::get('/autorias', function(){
    return view('autorias.index');
});
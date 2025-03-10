<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/nieuws/{id}', [NewsController::class, 'show'])->name('news.show');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('welcome');
});

// News
Route::get('/fetch-news', [ArticleController::class, 'fetchNews'])->name('articles.fetch');
Route::get('/news', [ArticleController::class, 'index'])->name('articles.index');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;

Route::get('/', [ArticleController::class, 'index'])->name('articles.index');

// News
Route::get('/fetch-news', [ArticleController::class, 'fetchNews'])->name('articles.fetch');
Route::get('/news', [ArticleController::class, 'index'])->name('articles.index');
Route::post('/articles/fetch-all', [ArticleController::class, 'fetchAllNews'])->name('articles.fetchAll');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

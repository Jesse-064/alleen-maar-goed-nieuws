<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

// Homepage - Lijst van artikelen
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/news', [ArticleController::class, 'index'])->name('articles.index');

// Ophalen van nieuwsartikelen via API
Route::get('/fetch-news', [ArticleController::class, 'fetchNews'])->name('articles.fetch');
Route::post('/articles/fetch-all', [ArticleController::class, 'fetchAllNews'])->name('articles.fetchAll');

// Detailpagina voor nieuwsartikelen
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Statische pagina's
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AccountController;

// Homepage - Lijst van artikelen
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/account/settings', [AccountController::class, 'edit'])->name('account.settings');
    Route::post('/account/settings', [AccountController::class, 'update'])->name('account.settings.update');
});

// News
Route::get('/fetch-news', [ArticleController::class, 'fetchNews'])->name('articles.fetch');
Route::get('/news', [ArticleController::class, 'index'])->name('articles.index');

// Ophalen van nieuwsartikelen via API
Route::get('/fetch-news', [ArticleController::class, 'fetchNews'])->name('articles.fetch');
Route::post('/articles/fetch-all', [ArticleController::class, 'fetchAllNews'])->name('articles.fetchAll');

// Detailpagina voor nieuwsartikelen
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Statische pagina's
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::get('/contact', function () {
    return view('contact');
});

Route::get('/settings', function () {
    return view('settings');
});

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

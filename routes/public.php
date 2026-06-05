<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InteracaoController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catálogo
Route::prefix('catalogo')->name('catalog.')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('/{slug}', [CatalogController::class, 'show'])->name('show');
});

// Blog
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// Interação (Tracking + Redirecionamento)
Route::get('/interacao/{tipo}/{produto}', [InteracaoController::class, 'redirect'])
    ->where('tipo', '[a-z]+')
    ->where('produto', '[0-9]+')
    ->name('interacao.redirect');
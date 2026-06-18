<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConfiguracaoSiteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InteracaoController;
use App\Http\Controllers\Admin\LojaVinculadaController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TipoInteracaoController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->name('admin.login');
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/metricas', [DashboardController::class, 'metricas'])->name('dashboard.metricas');

    // Produtos
    Route::resource('products', ProductController::class)->parameters([
        'products' => 'product',
    ]);
    Route::get('/products-table', [ProductController::class, 'table'])->name('products.table');

    // Categorias
    Route::get('/categories/list-all', [CategoryController::class, 'listAll'])->name('categories.list-all');
    Route::get('/categories-table', [CategoryController::class, 'table'])->name('categories.table');
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category',
    ]);

    // Postagens
    Route::resource('posts', PostController::class)->parameters([
        'posts' => 'post',
    ]);
    Route::get('/posts-table', [PostController::class, 'table'])->name('posts.table');

    // Interações
    Route::resource('interactions', InteracaoController::class)->only(['index', 'destroy'])->parameters([
        'interactions' => 'interacao',
    ]);

    // Tipos de Interação
    Route::get('/tipos-interacao/list-all', [TipoInteracaoController::class, 'listAll'])->name('tipos-interacao.list-all');
    Route::get('/tipos-interacao-table', [TipoInteracaoController::class, 'table'])->name('tipos-interacao.table');
    Route::patch('/tipos-interacao/{tipoInteracao}/toggle-ativo', [TipoInteracaoController::class, 'toggleAtivo'])->name('tipos-interacao.toggle-ativo');
    Route::resource('tipos-interacao', TipoInteracaoController::class)->parameters([
        'tipos-interacao' => 'tipoInteracao',
    ]);

    // Lojas Vinculadas
    Route::get('/lojas-vinculadas-table', [LojaVinculadaController::class, 'table'])->name('lojas-vinculadas.table');
    Route::resource('lojas-vinculadas', LojaVinculadaController::class)->parameters([
        'lojas-vinculadas' => 'lojaVinculada',
    ]);

    // Configurações do Site
    Route::resource('configuracoes', ConfiguracaoSiteController::class);

});

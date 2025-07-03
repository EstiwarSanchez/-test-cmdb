<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CmdbController;
use App\Http\Controllers\ImportExportController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('panel.index');
})->name('panel');


Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/404', function () {
    return view('pages.404');
});

Route::get('/500', function () {
    return view('pages.500');
});

Route::get('/401', function () {
    return view('pages.401');
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');

    // Rutas para CMDB
    Route::prefix('/{categoryId}/cmdb-items')->group(function () {
        Route::get('/create', action: [CmdbController::class, 'create'])->name('cmdb.create');
        Route::post('/', [CmdbController::class, 'store'])->name('cmdb.store');
        Route::get('/show', [CmdbController::class, 'show'])->name('cmdb.show');
        Route::get('/edit', [CmdbController::class, 'edit'])->name('cmdb.edit');
        Route::put('/{id}', [CmdbController::class, 'update'])->name('cmdb.update');
        Route::delete('/{id}', [CmdbController::class, 'destroy'])->name('cmdb.destroy');
        Route::post('/{estado}/deactivate', [CmdbController::class, 'deactivate'])->name('cmdb.deactivate');

        // Exportar/Importar
        Route::get('/export', [ImportExportController::class, 'export'])->name('cmdb.export');
        Route::post('/import', [ImportExportController::class, 'import'])->name('cmdb.import');
    });
});

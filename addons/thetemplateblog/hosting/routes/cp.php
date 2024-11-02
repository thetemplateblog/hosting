<?php

use Illuminate\Support\Facades\Route;
use Thetemplateblog\Hosting\Http\Controllers\ServerController;

Route::name('hosting.')->prefix('hosting')->group(function () {
    Route::get('/', [ServerController::class, 'index'])->name('servers.index');
    Route::get('/create', [ServerController::class, 'create'])->name('servers.create');
    Route::post('/', [ServerController::class, 'store'])->name('servers.store');
    Route::get('/{index}', [ServerController::class, 'show'])->name('servers.show');
    Route::get('/{index}/edit', [ServerController::class, 'edit'])->name('servers.edit');
    Route::patch('/{index}', [ServerController::class, 'update'])->name('servers.update');
    Route::delete('/{index}', [ServerController::class, 'destroy'])->name('servers.destroy');
});

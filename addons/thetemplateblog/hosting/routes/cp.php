<?php

use Illuminate\Support\Facades\Route;
use Thetemplateblog\Hosting\Http\Controllers\ServerController;
use Thetemplateblog\Hosting\Http\Controllers\ProviderController;

Route::name('hosting.')->prefix('hosting')->group(function () {
    // Provider routes (should come first as they're required for servers)
    Route::get('providers', [ProviderController::class, 'index'])->name('providers.index');
    Route::get('providers/create', [ProviderController::class, 'create'])->name('providers.create');
    Route::post('providers', [ProviderController::class, 'store'])->name('providers.store');
    Route::get('providers/{index}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
    Route::patch('providers/{index}', [ProviderController::class, 'update'])->name('providers.update');
    Route::delete('providers/{index}', [ProviderController::class, 'destroy'])->name('providers.destroy');

    // Server routes
    Route::get('/', [ServerController::class, 'index'])->name('servers.index');
    Route::get('create', [ServerController::class, 'create'])->name('servers.create');
    Route::post('/', [ServerController::class, 'store'])->name('servers.store');
    Route::get('{index}', [ServerController::class, 'show'])->name('servers.show');
    Route::get('{index}/edit', [ServerController::class, 'edit'])->name('servers.edit');
    Route::patch('{index}', [ServerController::class, 'update'])->name('servers.update');
    Route::delete('{index}', [ServerController::class, 'destroy'])->name('servers.destroy');
});

<?php

use Illuminate\Support\Facades\Route;
use Thetemplateblog\Hosting\Http\Controllers\ServerController;
use Thetemplateblog\Hosting\Http\Controllers\ProviderController;
use Thetemplateblog\Hosting\Http\Controllers\SiteController;

Route::name('hosting.')->prefix('hosting')->group(function () {

    // ===== Sites Routes =====
    Route::get('sites', [SiteController::class, 'index'])->name('sites.index');
    Route::get('sites/create', [SiteController::class, 'create'])->name('sites.create');
    Route::post('sites', [SiteController::class, 'store'])->name('sites.store');
    Route::get('sites/{index}/edit', [SiteController::class, 'edit'])->name('sites.edit');
    Route::patch('sites/{index}', [SiteController::class, 'update'])->name('sites.update');
    Route::delete('sites/{index}', [SiteController::class, 'destroy'])->name('sites.destroy');

    // Deploy Single Site Route
    Route::post('sites/{index}/deploy', [SiteController::class, 'deploySingle'])->name('sites.deploy.single');

    // ===== Provider Routes =====
    Route::get('providers', [ProviderController::class, 'index'])->name('providers.index');
    Route::get('providers/create', [ProviderController::class, 'create'])->name('providers.create');
    Route::post('providers', [ProviderController::class, 'store'])->name('providers.store');
    Route::get('providers/{index}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
    Route::patch('providers/{index}', [ProviderController::class, 'update'])->name('providers.update');
    Route::delete('providers/{index}', [ProviderController::class, 'destroy'])->name('providers.destroy');

    // ===== Server Routes =====
    Route::get('servers', [ServerController::class, 'index'])->name('servers.index');
    Route::get('servers/create', [ServerController::class, 'create'])->name('servers.create');
    Route::post('servers', [ServerController::class, 'store'])->name('servers.store');
    Route::get('servers/{index}', [ServerController::class, 'show'])->name('servers.show');
    Route::get('servers/{index}/edit', [ServerController::class, 'edit'])->name('servers.edit');
    Route::patch('servers/{index}', [ServerController::class, 'update'])->name('servers.update');
    Route::delete('servers/{index}', [ServerController::class, 'destroy'])->name('servers.destroy');

    // Deploy Single Server Route
    Route::post('servers/{index}/deploy', [ServerController::class, 'deploySingle'])->name('servers.deploy.single');
});

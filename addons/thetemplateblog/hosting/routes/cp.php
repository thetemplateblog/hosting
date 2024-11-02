<?php

use Illuminate\Support\Facades\Route;
use Thetemplateblog\Hosting\Http\Controllers\HostingController;

Route::prefix('hosting')->name('statamic.cp.hosting.')->group(function () {
    Route::get('/', [HostingController::class, 'index'])->name('index');
});

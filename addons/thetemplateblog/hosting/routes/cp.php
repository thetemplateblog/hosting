<?php

use Illuminate\Support\Facades\Route;
use Thetemplatesblog\Hosting\Http\Controllers\HostingController;

Route::prefix('hosting')->group(function () {
    Route::get('/', [HostingController::class, 'index'])->name('hosting.index');
});

<?php

use Illuminate\Support\Facades\Route;

Route::any('/generator/{action?}/{id?}', [\App\Http\Plugins\Front\Controllers\ImageController::class, 'image'])->name('generator');

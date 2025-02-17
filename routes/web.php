<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front.pages.front');
});

//Route::any('/generator', [\App\Http\Plugins\Front\Controllers\ImageController::class, 'image'])->name('generator');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/shipment', [\App\Http\Controllers\ShipmentController::class, 'create'])->name('shipment.create');
Route::post('/shipment/store/{delivery}', [\App\Http\Controllers\ShipmentController::class, 'store'])->name('shipment.store');

require __DIR__ . '/auth.php';

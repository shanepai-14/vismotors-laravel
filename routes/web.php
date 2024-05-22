<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotorColorKeyController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('brand', BrandController::class);
    Route::resource('motor', MotorController::class);
    Route::resource('transaction_type', TransactionTypeController::class);
    Route::resource('occupation', OccupationController::class);
    Route::resource('user', UserController::class);
    Route::get('/employee', [UserController::class, 'employee'])->name('user.employee');
    Route::get('/employee/create', [UserController::class, 'createEmployee'])->name('user.employee.create');
    Route::get('/employee/{user}/edit', [UserController::class, 'editEmployee'])->name('user.employee.edit');
    Route::resource('transaction', TransactionController::class);
    Route::get('/transaction_payment/{transaction}', [TransactionController::class, 'pay'])->name('payment.transaction');
    Route::post('/transaction_payment/paid', [TransactionController::class, 'paid'])->name('payment.paid');
    Route::get('/motor/{motor}/color', [MotorColorKeyController::class, 'index'])->name('color.index');
    Route::get('/motor/{motor}/color/create', [MotorColorKeyController::class, 'create'])->name('color.create');
    Route::post('/motor/{motor}/color/create', [MotorColorKeyController::class, 'store'])->name('color.store');
    Route::get('/motor/{motor}/color/{color}/edit', [MotorColorKeyController::class, 'edit'])->name('color.edit');
    Route::put('/motor/{motor}/color/{color}/edit', [MotorColorKeyController::class, 'update'])->name('color.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(UploadController::class)->group(function () {

        Route::post('/upload', 'store');
        // Route::post('/update', 'update');
        // Route::post('/upload-gallery', 'storeGallery');
        Route::post('/delete-temporary', 'deleteTemporary');
        // Route::post('/upload-chief', 'storeChief');
///documents routes 
});
});

require __DIR__.'/auth.php';

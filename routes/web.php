<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotorColorKeyController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('brand', BrandController::class);
    Route::resource('motor', MotorController::class);
    Route::resource('transaction_type', TransactionTypeController::class);
    Route::put('/status', [TransactionController::class, 'status'])->name('status.update');
    Route::resource('occupation', OccupationController::class);
    Route::resource('motor_color', MotorcycleController::class);
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
    Route::put('/quantity', [MotorColorKeyController::class, 'updateQuantity'])->name('quantity.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/monthly_report', [TransactionController::class, 'monthly_report'])->name('monthly_report');
    Route::get('/report', [TransactionController::class, 'report_index'])->name('report');
    Route::controller(UploadController::class)->group(function () {
    
        Route::post('/upload', 'store');
        // Route::post('/update', 'update');
        // Route::post('/upload-gallery', 'storeGallery');
        Route::post('/delete-temporary', 'deleteTemporary');
        // Route::post('/upload-chief', 'storeChief');
///documents routes 
});

Route::get('/link', function() {
    Artisan::call('storage:link');
});
});

require __DIR__.'/auth.php';

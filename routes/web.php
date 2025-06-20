<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesOrderController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {


//     Route::middleware('role:admin')->group(function () {
//         Route::resource('products', ProductController::class);
//     });

//       Route::middleware('role:admin,salesperson')->group(function () {
//         Route::resource('sales-orders', SalesOrderController::class);
//         Route::get('sales-orders/{salesOrder}/pdf', [SalesOrderController::class, 'exportPdf'])->name('sales-orders.pdf');
//     });
// });


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin: Products
    Route::middleware('role:admin')->group(function () {
        Route::resource('products', ProductController::class);
    });

    // Admin & Salesperson: Sales Orders
    Route::middleware('role:admin,salesperson')->group(function () {
        Route::resource('sales-orders', SalesOrderController::class);
        Route::get('sales-orders/{salesOrder}/pdf', [SalesOrderController::class, 'exportPdf'])
        ->name('sales-orders.pdf');
    });
});


require __DIR__.'/auth.php';

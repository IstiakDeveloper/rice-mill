<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BagController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/admin/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/admin/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/admin/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/admin/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/admin/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/admin/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/admin/customers/{customer}/pay', [CustomerController::class, 'pay'])->name('customers.pay');


    Route::get('/admin/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/admin/customers/{customer}/bags', [BagController::class, 'store'])->name('bags.store');
    Route::post('/admin/customers/{customer}/pay', [CustomerController::class, 'pay'])->name('customers.pay');

    Route::post('/customers/{customer}/payments', [BagController::class, 'pay'])->name('bags.pay');
    Route::get('/bags/pdf/{customer}', [BagController::class, 'pdf'])->name('bags.pdf');

});

Route::get('/migrate-and-seed', function () {
    Artisan::call('migrate:seed');
    return 'Database migrated and seeded.';
});



require __DIR__.'/auth.php';

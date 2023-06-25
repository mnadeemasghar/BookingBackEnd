<?php

use Illuminate\Support\Facades\Route;

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


//Clear Cache facade value:
Route::get('/clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('optimize');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    return '<h1>Cache facade value cleared</h1>';
});

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('users', [App\Http\Controllers\HomeController::class, 'users'])->name('users');
    Route::get('users/delete/{id}', [App\Http\Controllers\HomeController::class, 'usersDelete'])->name('deleteUsers');
    Route::get('partners', [App\Http\Controllers\HomeController::class, 'partners'])->name('partners');
    Route::get('add-partners', [App\Http\Controllers\HomeController::class, 'addPartners'])->name('addPartners');
    Route::get('edit-partners/{id}', [App\Http\Controllers\HomeController::class, 'editPartners'])->name('editPartners');
    Route::post('update-partners/{id}', [App\Http\Controllers\HomeController::class, 'updatePartners'])->name('updatePartners');
    Route::post('store-partners', [App\Http\Controllers\HomeController::class, 'storePartners'])->name('storePartners');
    Route::get('drivers', [App\Http\Controllers\HomeController::class, 'drivers'])->name('drivers');
    Route::get('add-drivers', [App\Http\Controllers\HomeController::class, 'addDrivers'])->name('addDrivers');
    Route::get('edit-drivers/{id}', [App\Http\Controllers\HomeController::class, 'editDrivers'])->name('editDrivers');
    Route::post('store-drivers', [App\Http\Controllers\HomeController::class, 'storeDrivers'])->name('storeDrivers');
    Route::post('update-drivers/{id}', [App\Http\Controllers\HomeController::class, 'updateDrivers'])->name('updateDrivers');
    Route::get('vehicles', [App\Http\Controllers\HomeController::class, 'vehicles'])->name('vehicles');
    Route::get('bookings', [App\Http\Controllers\HomeController::class, 'bookings'])->name('bookings');
    Route::get('add_booking', [App\Http\Controllers\HomeController::class, 'addBooking'])->name('addBooking');
    Route::get('extras', [App\Http\Controllers\HomeController::class, 'extras'])->name('extras');
    Route::get('logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
});


Route::get('signin', [App\Http\Controllers\HomeController::class, 'signin'])->name('login');
Route::post('signin_check', [App\Http\Controllers\HomeController::class, 'signin_check'])->name('login_check');
Route::get('signup', [App\Http\Controllers\HomeController::class, 'signup'])->name('signup');




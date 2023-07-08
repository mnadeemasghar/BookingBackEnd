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
    Route::get('vehicle/delete/{id}', [App\Http\Controllers\HomeController::class, 'deleteVehicle'])->name('deleteVehicle');
    Route::get('booking/delete/{id}', [App\Http\Controllers\HomeController::class, 'deleteBooking'])->name('deleteBooking');
    Route::get('passenger/delete/{id}', [App\Http\Controllers\HomeController::class, 'deletePassenger'])->name('deletePassenger');
    Route::get('booking/status-change/{id}/{status}', [App\Http\Controllers\HomeController::class, 'statusChangeBooking'])->name('statusChangeBooking');
    Route::get('accept-booking/{id}', [App\Http\Controllers\HomeController::class, 'acceptBooking'])->name('acceptBooking');
    Route::get('arrive-booking/{id}', [App\Http\Controllers\HomeController::class, 'arriveBooking'])->name('arriveBooking');
    Route::get('onboard-booking/{id}', [App\Http\Controllers\HomeController::class, 'onboardBooking'])->name('onboardBooking');
    Route::get('complete-booking/{id}', [App\Http\Controllers\HomeController::class, 'completeBooking'])->name('completeBooking');
    Route::get('reject-booking/{id}', [App\Http\Controllers\HomeController::class, 'rejectBooking'])->name('rejectBooking');
    Route::post('reject-booking/{id}', [App\Http\Controllers\HomeController::class, 'rejectBookingPost'])->name('rejectBookingPost');
    Route::get('noshow-booking/{id}', [App\Http\Controllers\HomeController::class, 'noshowBooking'])->name('noshowBooking');
    Route::post('noshow-booking/{id}', [App\Http\Controllers\HomeController::class, 'noshowBookingPost'])->name('noshowBookingPost');
    Route::get('partners', [App\Http\Controllers\HomeController::class, 'partners'])->name('partners');
    Route::get('vehicleTypes', [App\Http\Controllers\HomeController::class, 'vehicleTypes'])->name('vehicleTypes');
    Route::get('add-vehicle', [App\Http\Controllers\HomeController::class, 'addVehicle'])->name('addVehicle');
    Route::get('add-partners', [App\Http\Controllers\HomeController::class, 'addPartners'])->name('addPartners');
    Route::get('assign-driver/{booking_id}', [App\Http\Controllers\HomeController::class, 'assignDriver'])->name('assignDriver');
    Route::post('assign-driver-store/{booking_id}', [App\Http\Controllers\HomeController::class, 'assignDriverStore'])->name('assignDriverStore');
    Route::get('edit-vehicle/{id}', [App\Http\Controllers\HomeController::class, 'editVehicle'])->name('editVehicle');
    Route::get('edit-passenger/{id}', [App\Http\Controllers\HomeController::class, 'editPassenger'])->name('editPassenger');
    Route::get('edit-booking/{id}', [App\Http\Controllers\HomeController::class, 'editBooking'])->name('editBooking');
    Route::get('edit-partners/{id}', [App\Http\Controllers\HomeController::class, 'editPartners'])->name('editPartners');
    Route::post('update-vehicle/{id}', [App\Http\Controllers\HomeController::class, 'updateVehicle'])->name('updateVehicle');
    Route::post('update-booking/{id}', [App\Http\Controllers\HomeController::class, 'updateBooking'])->name('updateBooking');
    Route::post('update-passenger/{id}', [App\Http\Controllers\HomeController::class, 'updatePassenger'])->name('updatePassenger');
    Route::post('update-partners/{id}', [App\Http\Controllers\HomeController::class, 'updatePartners'])->name('updatePartners');
    Route::post('store-vehicle', [App\Http\Controllers\HomeController::class, 'storeVehicle'])->name('storeVehicle');
    Route::post('store-booking', [App\Http\Controllers\HomeController::class, 'storeBooking'])->name('storeBooking');
    Route::post('store-passenger/{booking_id}', [App\Http\Controllers\HomeController::class, 'storePassenger'])->name('storePassenger');
    Route::post('store-partners', [App\Http\Controllers\HomeController::class, 'storePartners'])->name('storePartners');
    Route::get('drivers', [App\Http\Controllers\HomeController::class, 'drivers'])->name('drivers');
    Route::get('passengers/{booking_id}', [App\Http\Controllers\HomeController::class, 'passengers'])->name('passengers');
    Route::get('view-passengers/{booking_id}', [App\Http\Controllers\HomeController::class, 'viewPassengers'])->name('viewPassengers');
    Route::get('view-logs/{booking_id}', [App\Http\Controllers\HomeController::class, 'viewLogs'])->name('viewLogs');
    Route::get('add-drivers', [App\Http\Controllers\HomeController::class, 'addDrivers'])->name('addDrivers');
    Route::get('add-passenger/{booking_id}', [App\Http\Controllers\HomeController::class, 'addPassenger'])->name('addPassenger');
    Route::get('edit-drivers/{id}', [App\Http\Controllers\HomeController::class, 'editDrivers'])->name('editDrivers');
    Route::post('store-drivers', [App\Http\Controllers\HomeController::class, 'storeDrivers'])->name('storeDrivers');
    Route::post('update-drivers/{id}', [App\Http\Controllers\HomeController::class, 'updateDrivers'])->name('updateDrivers');
    Route::get('vehicles', [App\Http\Controllers\HomeController::class, 'vehicles'])->name('vehicles');
    Route::get('bookings', [App\Http\Controllers\HomeController::class, 'bookings'])->name('bookings');
    Route::get('booking-detail/{booking_id}', [App\Http\Controllers\HomeController::class, 'bookingDetail'])->name('bookingDetail');
    Route::get('pending-bookings', [App\Http\Controllers\HomeController::class, 'pendingBookings'])->name('pendingBookings');
    Route::get('accepted-bookings', [App\Http\Controllers\HomeController::class, 'acceptedBookings'])->name('acceptedBookings');
    Route::get('rejected-bookings', [App\Http\Controllers\HomeController::class, 'rejectedBookings'])->name('rejectedBookings');
    Route::get('assigned-bookings', [App\Http\Controllers\HomeController::class, 'assignedBookings'])->name('assignedBookings');
    Route::get('assigned-driver-bookings/{driver_id}', [App\Http\Controllers\HomeController::class, 'assignedDriverBookings'])->name('assignedDriverBookings');
    Route::get('arrived-bookings/{driver_id}', [App\Http\Controllers\HomeController::class, 'arrivedBookings'])->name('arrivedBookings');
    Route::get('onboard-bookings/{driver_id}', [App\Http\Controllers\HomeController::class, 'onboardBookings'])->name('onboardBookings');
    Route::get('completed-bookings/{driver_id}', [App\Http\Controllers\HomeController::class, 'completedBookings'])->name('completedBookings');
    Route::get('add_booking', [App\Http\Controllers\HomeController::class, 'addBooking'])->name('addBooking');
    Route::get('extras', [App\Http\Controllers\HomeController::class, 'extras'])->name('extras');
    Route::get('logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
    Route::get('logout-user/{id}', [App\Http\Controllers\HomeController::class, 'logoutUser'])->name('logoutUser');
});


Route::get('signin', [App\Http\Controllers\HomeController::class, 'signin'])->name('login');
Route::post('signin_check', [App\Http\Controllers\HomeController::class, 'signin_check'])->name('login_check');
Route::get('signup', [App\Http\Controllers\HomeController::class, 'signup'])->name('signup');




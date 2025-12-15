<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

Route::get('/', [HotelController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::resource('hotels', App\Http\Controllers\HotelController::class)
    ->names(['index' => 'hotels'])->middleware(['auth']);

// Routes to create/store rooms for a specific hotel
Route::get('hotels/{hotel}/rooms/create', [RoomController::class, 'create'])->name('hotels.rooms.create');
Route::post('hotels/{hotel}/rooms', [RoomController::class, 'store'])->name('hotels.rooms.store');
Route::get('rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::put('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');


Route::middleware(['auth','role:admin'])->group(function(){
    Route::resource('rooms', App\Http\Controllers\RoomController::class);
});
  
     

// صفحة الحجز
Route::get('/book', [BookingController::class, 'create'])->name('booking.create');

// تحقق من التوفر (AJAX)
Route::post('/check-availability', [BookingController::class, 'checkAvailability']);

// حجز جديد
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');



require __DIR__.'/auth.php';

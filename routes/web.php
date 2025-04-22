<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ComelecController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\officialController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/officials', [OfficialController::class, 'index'])->name('officials.index');
Route::get('/officials/create', [OfficialController::class, 'create'])->name('officials.create');
Route::post('/officials/store', [OfficialController::class, 'store'])->name('officials.store');
Route::get('/officials/edit/{id}', [OfficialController::class, 'edit'])->name('officials.edit');
Route::post('/officials/update/{id}', [OfficialController::class, 'update'])->name('officials.update');
Route::delete('/officials/{id}', [OfficialController::class, 'destroy'])->name('officials.destroy');
Route::get('/get-comelec-data', [OfficialController::class, 'getComelecData'])->name('getComelecData');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/auth', [RegisteredUserController::class, 'register'])->name('auth.register');
Route::post('/auth', [RegisteredUserController::class, 'register'])->name('auth.register'); 

Route::get('/users/list', [UsersController::class, 'index'])->name('users.list');
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');
Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');


Route::get('/comelecFolder', [ComelecController::class, 'comelecData'])->name('comelec');
Route::get('/comelec/create', [ComelecController::class, 'create'])->name('comelec.create');
Route::get('/get-name-details/{id}', [ComelecController::class, 'getNameDetails'])->name('get-name-details');

Route::get('/positionFolder', [PositionController::class, 'positionData'])->name('position.index');
Route::get('/position/create', [PositionController::class, 'create'])->name('position.create');
Route::post('/position/store', [PositionController::class, 'store'])->name('position.store');
Route::get('/position/edit/{id}', [PositionController::class, 'edit'])->name('position.edit');
Route::post('/position/update/{id}', [PositionController::class, 'update'])->name('position.update');
Route::delete('/position/{id}', [PositionController::class, 'destroy'])->name('position.destroy');            

require __DIR__.'/auth.php';

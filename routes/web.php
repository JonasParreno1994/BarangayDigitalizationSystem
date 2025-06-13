<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ComelecController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\officialController;
use App\Http\Controllers\FilesCategoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\DashboardController;
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


Route::get('/positionFolder', [PositionController::class, 'index'])->name('position.index');
Route::get('/position-folder', [PositionController::class, 'index'])->name('positionFolder.index');
Route::get('/positionFolder/create', [PositionController::class, 'create'])->name('position.create');
Route::post('/positionFolder/store', [PositionController::class, 'store'])->name('position.store');
Route::get('/positionFolder/edit/{id}', [PositionController::class, 'edit'])->name('position.edit');
Route::post('/positionFolder/update/{id}', [PositionController::class, 'update'])->name('position.update');
Route::delete('/positionFolder/{id}', [PositionController::class, 'destroy'])->name('position.destroy');

Route::get('/filesCategory', [FilesCategoryController::class, 'index'])->name('filescategory.index');
Route::get('/filesCategory/create', [FilesCategoryController::class, 'create'])->name('filescategory.create'); 
Route::post('/filesCategory/store', [FilesCategoryController::class, 'store'])->name('filescategory.store');
Route::get('/filesCategory/edit/{id}', [FilesCategoryController::class, 'edit'])->name('filescategory.edit');
Route::post('/filesCategory/update/{id}', [FilesCategoryController::class, 'update'])->name('filescategory.update');
Route::delete('/filesCategory/{id}', [FilesCategoryController::class, 'destroy'])->name('filescategory.destroy');

Route::get('/residentFolder', [ResidentController::class, 'index'])->name('resident.index');
Route::get('/residentFolder/create', [ResidentController::class, 'create'])->name('resident.create');
Route::post('/residentFolder/store', [ResidentController::class, 'store'])->name('resident.store');
Route::get('/residentFolder/edit/{id}', [ResidentController::class, 'edit'])->name('resident.edit');
Route::post('/residentFolder/update/{id}', [ResidentController::class, 'update'])->name('resident.update');
Route::delete('/residentFolder/{id}', [ResidentController::class, 'destroy'])->name('resident.destroy');
Route::get('/residentFolder/print/{id}', [ResidentController::class, 'print'])->name('resident.print');
Route::get('/residentFolder/printAll', [ResidentController::class, 'printAll'])->name('resident.printAll');
Route::get('/residentFolder/printAllPDF', [ResidentController::class, 'printAllPDF'])->name('resident.printAllPDF');
Route::get('/residentFolder/printAllPDF', [ResidentController::class, 'printAllPDF'])->name('resident.printAllPDF');



require __DIR__.'/auth.php';

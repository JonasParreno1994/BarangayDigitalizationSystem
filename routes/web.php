<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ComelecController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\officialController;
use App\Http\Controllers\FilesCategoryController;
use App\Http\Controllers\BrangayidDetailsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BrgyclearanceController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardItemController;
use App\Http\Controllers\PurokController;
use App\Http\Controllers\CertificateOfIndigencyController;
use App\Http\Controllers\BarangayGoodMoralCertificateController;
use App\Http\Controllers\CertificateOfResidencyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardItemController::class, 'overview'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/officials', [OfficialController::class, 'index'])->name('officials.index');
    Route::get('/officials/create', [OfficialController::class, 'create'])->name('officials.create');
    Route::post('/officials/store', [OfficialController::class, 'store'])->name('officials.store');
    Route::get('/officials/edit/{id}', [OfficialController::class, 'edit'])->name('officials.edit');
    Route::post('/officials/update/{id}', [OfficialController::class, 'update'])->name('officials.update');
    Route::delete('/officials/{id}', [OfficialController::class, 'destroy'])->name('officials.destroy');
    Route::get('/get-comelec-data', [OfficialController::class, 'getComelecData'])->name('getComelecData');

    Route::get('/auth', [RegisteredUserController::class, 'register'])->name('auth.register');
    Route::post('/auth', [RegisteredUserController::class, 'register'])->name('auth.register'); 

    Route::get('/users/list', [UsersController::class, 'index'])->name('users.list');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('/comelecFolder', [ComelecController::class, 'comelecData'])->name('comelec');
    Route::get('/comelec/create', [ComelecController::class, 'create'])->name('comelec.create');
    Route::get('/comelec/search', [ComelecController::class, 'search'])->name('comelec.search');

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

    Route::resource('purok', PurokController::class);

    Route::get('/barangayiddetails', [BrangayidDetailsController::class, 'index'])->name('barangayid.index');
    Route::get('/barangayiddetails/create', [BrangayidDetailsController::class, 'create'])->name('barangayid.create');
    Route::post('/barangayiddetails/store', [BrangayidDetailsController::class, 'store'])->name('barangayid.store');
    Route::get('/barangayiddetails/{id}/edit', [BrangayidDetailsController::class, 'edit'])->name('barangayid.edit');
    Route::put('/barangayiddetails/{id}/update', [BrangayidDetailsController::class, 'update'])->name('barangayid.update');
    Route::delete('/barangayiddetails/{id}', [BrangayidDetailsController::class, 'destroy'])->name('barangayid.destroy');

    Route::get('/residentFolder', [ResidentController::class, 'index'])->name('resident.index');
    Route::get('/residentFolder/create', [ResidentController::class, 'create'])->name('resident.create');
    Route::post('/residentFolder/store', [ResidentController::class, 'store'])->name('resident.store');
    Route::get('/residentFolder/{id}/view', [ResidentController::class, 'view'])->name('resident.view');
    Route::get('/residentFolder/{id}/edit', [ResidentController::class, 'edit'])->name('resident.edit');
    Route::put('/residentFolder/{id}/update', [ResidentController::class, 'update'])->name('resident.update'); 
    Route::delete('/residentFolder/{id}', [ResidentController::class, 'destroy'])->name('resident.destroy');
    Route::get('/residentFolder/{id}/print', [ResidentController::class, 'print'])->name('resident.print');
    Route::get('/residentFolder/{id}/printid', [ResidentController::class, 'printid'])->name('resident.printid');

    Route::get('/residentFolder/printAll', [ResidentController::class, 'printAll'])->name('resident.printAll');
    Route::get('/residentFolder/printAllPDF', [ResidentController::class, 'printAllPDF'])->name('resident.printAllPDF');
    Route::get('/residentFolder/printAllPDF', [ResidentController::class, 'printAllPDF'])->name('resident.printAllPDF');

    Route::get('/barangayclearance', [BrgyclearanceController::class, 'index'])->name('barangayclearance.index');
    Route::post('/barangayclearance', [BrgyclearanceController::class, 'store'])->name('barangayclearance.store');
    Route::get('/barangayclearance/{id}', [BrgyclearanceController::class, 'show'])->name('barangayclearance.show');
    Route::get('/barangayclearance/{id}/edit', [BrgyclearanceController::class, 'edit'])->name('barangayclearance.edit');
    Route::put('/barangayclearance/{id}', [BrgyclearanceController::class, 'update'])->name('barangayclearance.update');
    Route::delete('/barangayclearance/{id}', [BrgyclearanceController::class, 'destroy'])->name('barangayclearance.destroy');
    Route::get('/barangayclearance/{id}/print', [BrgyclearanceController::class, 'print'])->name('barangayclearance.print');

    Route::get('/residentsgraph', [DashboardController::class, 'residentsgraph'])->name('dashboard.residentsgraph');

    Route::get('/certificate_of_indigency', [CertificateOfIndigencyController::class, 'index'])->name('certificate_of_indigency.index');
    Route::post('/certificate_of_indigency', [CertificateOfIndigencyController::class, 'store'])->name('certificate_of_indigency.store');
    Route::get('/certificate_of_indigency/{id}', [CertificateOfIndigencyController::class, 'show'])->name('certificate_of_indigency.show');
    Route::get('/certificate_of_indigency/{id}/edit', [CertificateOfIndigencyController::class, 'edit'])->name('certificate_of_indigency.edit');
    Route::put('/certificate_of_indigency/{id}', [CertificateOfIndigencyController::class, 'update'])->name('certificate_of_indigency.update');
    Route::delete('/certificate_of_indigency/{id}', [CertificateOfIndigencyController::class, 'destroy'])->name('certificate_of_indigency.destroy');
    Route::get('/certificate_of_indigency/{id}/print', [CertificateOfIndigencyController::class, 'print'])->name('certificate_of_indigency.print');

    Route::resource('barangaygoodmoral', BarangayGoodMoralCertificateController::class);
    Route::get('barangaygoodmoral/{id}/print', [BarangayGoodMoralCertificateController::class, 'print'])
    ->name('barangaygoodmoral.print');

    Route::resource('certificate-of-residency', CertificateOfResidencyController::class);
    Route::get('/certificate-of-residency/{id}/print', [CertificateOfResidencyController::class, 'print'])->name('certificate-of-residency.print');

    Route::resource('dashboard-items', DashboardItemController::class)->except(['show']);
    Route::get('/dashboard-items/overview', [DashboardItemController::class, 'overview'])->name('dashboard.overview');
});

require __DIR__.'/auth.php';
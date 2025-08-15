<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ComelecController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\officialController;
use App\Http\Controllers\FilesCategoryController;
use APP\Http\Controllers\filesController;
use App\Http\Controllers\FileController; 
use App\Http\Controllers\BrangayidDetailsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BrgyclearanceController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\DocumentController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardItemController;
use App\Http\Controllers\CertificationFooterController;
use App\Http\Controllers\PurokController;
use App\Http\Controllers\CertificateOfIndigencyController;
use App\Http\Controllers\BarangayGoodMoralCertificateController;
use App\Http\Controllers\CertificateOfResidencyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpecialReportController;
use App\Http\Controllers\CertIndigencyMinorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'residentsgraph'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('users.list');
    Route::get('/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    });
    
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

    Route::resource('documents', DocumentController::class);
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    Route::resource('purok', PurokController::class);

    Route::get('/barangayiddetails', [BrangayidDetailsController::class, 'index'])->name('barangayid.index');
    Route::get('/barangayiddetails/create', [BrangayidDetailsController::class, 'create'])->name('barangayid.create');
    Route::post('/barangayiddetails/store', [BrangayidDetailsController::class, 'store'])->name('barangayid.store');
    Route::get('/barangayiddetails/{id}/edit', [BrangayidDetailsController::class, 'edit'])->name('barangayid.edit');
    Route::put('/barangayiddetails/{id}/update', [BrangayidDetailsController::class, 'update'])->name('barangayid.update');
    Route::delete('/barangayiddetails/{id}', [BrangayidDetailsController::class, 'destroy'])->name('barangayid.destroy');

    Route::prefix('certification-footer')->group(function () {
    Route::get('/', [CertificationFooterController::class, 'index'])->name('certification-footer.index');
    Route::get('/create', [CertificationFooterController::class, 'create'])->name('certification-footer.create');
    Route::post('/', [CertificationFooterController::class, 'store'])->name('certification-footer.store');
    Route::get('/{id}/edit', [CertificationFooterController::class, 'edit'])->name('certification-footer.edit');
    Route::put('/{id}', [CertificationFooterController::class, 'update'])->name('certification-footer.update');
});

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

    Route::prefix('resident/{resident}')->group(function () {
    Route::get('/files', [FileController::class, 'index'])->name('resident.files.index');
    Route::get('/files/create', [FileController::class, 'create'])->name('resident.files.create');
    Route::post('/files', [FileController::class, 'store'])->name('resident.files.store');
    Route::get('/files/{file}', [FileController::class, 'show'])->name('resident.files.show');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('resident.files.download');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('resident.files.destroy');
    });

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


    Route::get('/cert_indigency_minor', [CertIndigencyMinorController::class, 'index'])->name('cert_indigency_minor.index');
    Route::post('/cert_indigency_minor', [CertIndigencyMinorController::class, 'store'])->name('cert_indigency_minor.store');
    Route::get('/cert_indigency_minor/{id}', [CertIndigencyMinorController::class, 'show'])->name('cert_indigency_minor.show');
    Route::get('/cert_indigency_minor/{id}/edit', [CertIndigencyMinorController::class, 'edit'])->name('cert_indigency_minor.edit');
    Route::put('/cert_indigency_minor/{id}', [CertIndigencyMinorController::class, 'update'])->name('cert_indigency_minor.update');
    Route::delete('/cert_indigency_minor/{id}', [CertIndigencyMinorController::class, 'destroy'])->name('cert_indigency_minor.destroy');
    Route::get('/cert_indigency_minor/{id}/print', [CertIndigencyMinorController::class, 'print'])->name('cert_indigency_minor.print');
    Route::get('/cert-indigency-minor/report', [CertIndigencyMinorController::class, 'report'])->name('cert_indigency_minor.report');

    
    

    Route::resource('barangaygoodmoral', BarangayGoodMoralCertificateController::class);
    Route::get('barangaygoodmoral/{id}/print', [BarangayGoodMoralCertificateController::class, 'print'])
    ->name('barangaygoodmoral.print');

    Route::resource('certificate-of-residency', CertificateOfResidencyController::class);
    Route::get('/certificate-of-residency/{id}/print', [CertificateOfResidencyController::class, 'print'])->name('certificate-of-residency.print');

    Route::resource('dashboard-items', DashboardItemController::class)->except(['show']);
    Route::get('/dashboard-items/overview', [DashboardItemController::class, 'overview'])->name('dashboard.overview');

    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/generate', [ReportController::class, 'generate'])->name('reports.generate');
        Route::get('/print', [ReportController::class, 'print'])->name('reports.print');
    });

    
    Route::prefix('special-reports')->group(function () {
    Route::get('/', [SpecialReportController::class, 'index'])->name('special-reports.index');
    Route::post('/generate', [SpecialReportController::class, 'generate'])->name('special-reports.generate');
    Route::get('/print', [SpecialReportController::class, 'print'])->name('special-reports.print');

    Route::post('/generate-purok', [SpecialReportController::class, 'generatePurokReport'])->name('special-reports.generate-purok');
    Route::get('/print-purok', [SpecialReportController::class, 'printPurokReport'])->name('special-reports.print-purok');
    
    // Age bracket reports
    Route::post('/generate-age-bracket', [SpecialReportController::class, 'generateAgeBracketReport'])
        ->name('special-reports.generate-age-bracket');
    Route::get('/print-age-bracket', [SpecialReportController::class, 'printAgeBracketReport'])
        ->name('special-reports.print-age-bracket');
        
    // Sector reports
    Route::post('/generate-sector', [SpecialReportController::class, 'generateSectorReport'])
        ->name('special-reports.generate-sector');
    Route::get('/print-sector', [SpecialReportController::class, 'printSectorReport'])
        ->name('special-reports.print-sector');
    });
});

require __DIR__.'/auth.php';
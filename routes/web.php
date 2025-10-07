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
use App\Http\Controllers\CertFirstTimeJobseekerController;
use App\Http\Controllers\CertificateOfDeathController;
use App\Http\Controllers\RbiFormCController;
use App\Http\Controllers\BarangayDetailController;
use App\Http\Controllers\BarangayCertificateController;
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

    // Barangay Details Management
    Route::get('/barangaydetails', [BarangayDetailController::class, 'index'])->name('barangaydetails.index');
    Route::get('/barangay-details', [BarangayDetailController::class, 'index'])->name('barangay-details.index');
    Route::get('/barangay-details/create', [BarangayDetailController::class, 'create'])->name('barangay-details.create');
    Route::post('/barangay-details', [BarangayDetailController::class, 'store'])->name('barangay-details.store');
    Route::get('/barangay-details/{id}/edit', [BarangayDetailController::class, 'edit'])->name('barangay-details.edit');
    Route::put('/barangay-details/{id}', [BarangayDetailController::class, 'update'])->name('barangay-details.update');
    Route::delete('/barangay-details/{id}', [BarangayDetailController::class, 'destroy'])->name('barangay-details.destroy');

    Route::get('/auth', [RegisteredUserController::class, 'register'])->name('auth.register');
    Route::post('/auth', [RegisteredUserController::class, 'store'])->name('auth.store'); 

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
    Route::get('/residentFolder/search', [ResidentController::class, 'search'])->name('resident.search');
    Route::get('/residentFolder/{id}/view', [ResidentController::class, 'view'])->name('resident.view');
    Route::get('/residentFolder/{id}/edit', [ResidentController::class, 'edit'])->name('resident.edit');
    Route::put('/residentFolder/{id}/update', [ResidentController::class, 'update'])->name('resident.update'); 
    Route::delete('/residentFolder/{id}', [ResidentController::class, 'destroy'])->name('resident.destroy');
    Route::get('/residentFolder/{id}/print', [ResidentController::class, 'print'])->name('resident.print');
    Route::get('/residentFolder/{id}/printid', [ResidentController::class, 'printid'])->name('resident.printid');
    Route::get('/residentFolder/{id}/printrbi', [ResidentController::class, 'printrbi'])->name('resident.printrbi');
    Route::post('/residentFolder/{id}/status', [ResidentController::class, 'updateStatus'])->name('resident.updateStatus');


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
    Route::get('/barangayclearance/report', [BrgyclearanceController::class, 'report'])->name('barangayclearance.report');
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
    Route::get('/certificate_of_indigency/{id}/print', [CertificateOfIndigencyController::class, 'print'])->name
    ('certificate_of_indigency.print');
    Route::get('/certificate-of-indigency/report', [CertificateOfIndigencyController::class, 'report'])->name('certificate_of_indigency.report');

    Route::prefix('certificate-of-death')->group(function () {
    Route::get('/', [CertificateOfDeathController::class, 'index'])->name('certificate-of-death.index');
    Route::get('/create', [CertificateOfDeathController::class, 'create'])->name('certificate-of-death.create');
    Route::post('/', [CertificateOfDeathController::class, 'store'])->name('certificate-of-death.store');
    Route::get('/report', [CertificateOfDeathController::class, 'report'])->name('certificate_of_death.report');
    Route::get('/{id}', [CertificateOfDeathController::class, 'show'])->name('certificate-of-death.show');
    Route::get('/{id}/edit', [CertificateOfDeathController::class, 'edit'])->name('certificate-of-death.edit');
    Route::put('/{id}', [CertificateOfDeathController::class, 'update'])->name('certificate-of-death.update');
    Route::delete('/{id}', [CertificateOfDeathController::class, 'destroy'])->name('certificate-of-death.destroy');
    Route::get('/{id}/print', [CertificateOfDeathController::class, 'print'])->name('certificate-of-death.print');
});


    Route::get('/cert_indigency_minor', [CertIndigencyMinorController::class, 'index'])->name('cert_indigency_minor.index');
    Route::post('/cert_indigency_minor', [CertIndigencyMinorController::class, 'store'])->name('cert_indigency_minor.store');
    Route::get('/cert_indigency_minor/{id}', [CertIndigencyMinorController::class, 'show'])->name('cert_indigency_minor.show');
    Route::get('/cert_indigency_minor/{id}/edit', [CertIndigencyMinorController::class, 'edit'])->name('cert_indigency_minor.edit');
    Route::put('/cert_indigency_minor/{id}', [CertIndigencyMinorController::class, 'update'])->name('cert_indigency_minor.update');
    Route::delete('/cert_indigency_minor/{id}', [CertIndigencyMinorController::class, 'destroy'])->name('cert_indigency_minor.destroy');
    Route::get('/cert_indigency_minor/{id}/print', [CertIndigencyMinorController::class, 'print'])->name('cert_indigency_minor.print');
    Route::get('/cert-indigency-minor/report', [CertIndigencyMinorController::class, 'report'])->name('cert_indigency_minor.report');


    Route::get('/cert_firstTime_Jobseeker', [CertFirstTimeJobseekerController::class, 'index'])->name('cert_firstTime_Jobseeker.index');
    Route::post('/cert_firstTime_Jobseeker', [CertFirstTimeJobseekerController::class, 'store'])->name('cert_firstTime_Jobseeker.store');
    Route::get('/cert_firstTime_Jobseeker/{id}', [CertFirstTimeJobseekerController::class, 'show'])->name('cert_firstTime_Jobseeker.show');
    Route::get('/cert_firstTime_Jobseeker/{id}/edit', [CertFirstTimeJobseekerController::class, 'edit'])->name('cert_firstTime_Jobseeker.edit');
    Route::put('/cert_firstTime_Jobseeker/{id}', [CertFirstTimeJobseekerController::class, 'update'])->name('cert_firstTime_Jobseeker.update');
    Route::delete('/cert_firstTime_Jobseeker/{id}', [CertFirstTimeJobseekerController::class, 'destroy'])->name('cert_firstTime_Jobseeker.destroy');
    Route::get('/cert_firstTime_Jobseeker/{id}/print', [CertFirstTimeJobseekerController::class, 'print'])->name('cert_firstTime_Jobseeker.print');
    Route::get('/cert-firstTime-Jobseeker/report', [CertFirstTimeJobseekerController::class, 'report'])->name('cert_firstTime_Jobseeker.report');

    
    

    Route::resource('barangaygoodmoral', BarangayGoodMoralCertificateController::class);
    Route::get('barangaygoodmoral/{id}/print', [BarangayGoodMoralCertificateController::class, 'print'])
    ->name('barangaygoodmoral.print');
    Route::get('/barangay-good-moral/report', [BarangayGoodMoralCertificateController::class, 'report'])->name('barangay-good-moral.report');

    Route::get('/certificate-of-residency', [CertificateOfResidencyController::class, 'index'])->name('certificate-of-residency.index');
    Route::post('/certificate-of-residency', [CertificateOfResidencyController::class, 'store'])->name('certificate-of-residency.store');
    Route::get('/certificate-of-residency/report', [CertificateOfResidencyController::class, 'report'])->name('certificate-of-residency.report');
    Route::get('/certificate-of-residency/{id}', [CertificateOfResidencyController::class, 'show'])->name('certificate-of-residency.show');
    Route::get('/certificate-of-residency/{id}/edit', [CertificateOfResidencyController::class, 'edit'])->name('certificate-of-residency.edit');
    Route::put('/certificate-of-residency/{id}', [CertificateOfResidencyController::class, 'update'])->name('certificate-of-residency.update');
    Route::delete('/certificate-of-residency/{id}', [CertificateOfResidencyController::class, 'destroy'])->name('certificate-of-residency.destroy');
    Route::get('/certificate-of-residency/{id}/print', [CertificateOfResidencyController::class, 'print'])->name('certificate-of-residency.print');

    Route::get('/barangay-certificate', [BarangayCertificateController::class, 'index'])->name('barangay-certificate.index');
    Route::post('/barangay-certificate', [BarangayCertificateController::class, 'store'])->name('barangay-certificate.store');
    Route::get('/barangay-certificate/report', [BarangayCertificateController::class, 'report'])->name('barangay-certificate.report');
    Route::get('/barangay-certificate/{id}', [BarangayCertificateController::class, 'show'])->name('barangay-certificate.show');
    Route::get('/barangay-certificate/{id}/edit', [BarangayCertificateController::class, 'edit'])->name('barangay-certificate.edit');
    Route::put('/barangay-certificate/{id}', [BarangayCertificateController::class, 'update'])->name('barangay-certificate.update');
    Route::delete('/barangay-certificate/{id}', [BarangayCertificateController::class, 'destroy'])->name('barangay-certificate.destroy');
    Route::get('/barangay-certificate/{id}/print', [BarangayCertificateController::class, 'print'])->name('barangay-certificate.print');

    Route::resource('dashboard-items', DashboardItemController::class)->except(['show']);
    Route::get('/dashboard-items/overview', [DashboardItemController::class, 'overview'])->name('dashboard.overview');

    // Household routes
    Route::resource('households', App\Http\Controllers\HouseholdController::class);
    Route::get('/households/{household}/print', [App\Http\Controllers\HouseholdController::class, 'print'])->name('households.print');
    Route::get('/households/{household}/add-member', [App\Http\Controllers\HouseholdController::class, 'addMember'])->name('households.add-member');
    Route::post('/households/{household}/members', [App\Http\Controllers\HouseholdController::class, 'storeMember'])->name('households.store-member');
    Route::get('/households/{household}/members/{member}/edit', [App\Http\Controllers\HouseholdController::class, 'editMember'])->name('households.edit-member');
    Route::put('/households/{household}/members/{member}', [App\Http\Controllers\HouseholdController::class, 'updateMember'])->name('households.update-member');
    Route::delete('/households/{household}/members/{member}', [App\Http\Controllers\HouseholdController::class, 'destroyMember'])->name('households.destroy-member');

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
    
   
    Route::post('/generate-age-bracket', [SpecialReportController::class, 'generateAgeBracketReport'])
        ->name('special-reports.generate-age-bracket');
    Route::get('/print-age-bracket', [SpecialReportController::class, 'printAgeBracketReport'])
        ->name('special-reports.print-age-bracket');
        
  
    Route::post('/generate-sector', [SpecialReportController::class, 'generateSectorReport'])
        ->name('special-reports.generate-sector');
    Route::get('/print-sector', [SpecialReportController::class, 'printSectorReport'])
        ->name('special-reports.print-sector');
    });

    // RBI Form C Routes
    Route::prefix('rbi-form-c')->group(function () {
        Route::get('/', [RbiFormCController::class, 'index'])->name('rbi-form-c.index');
        Route::post('/generate', [RbiFormCController::class, 'generate'])->name('rbi-form-c.generate');
    });
});

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeOne\AaiController;
use App\Http\Controllers\ThemeOne\SFAController;
use App\Http\Controllers\ThemeOne\FDTLController;
use App\Http\Controllers\ThemeOne\HomeController;
use App\Http\Controllers\ThemeOne\UserController;
use App\Http\Controllers\ThemeOne\FlyingController;
use App\Http\Controllers\ThemeOne\MyLeaveController;
use App\Http\Controllers\ThemeOne\ReportsController;
use App\Http\Controllers\ThemeOne\AirCraftController;
use App\Http\Controllers\ThemeOne\ContractController;
use App\Http\Controllers\ThemeOne\LoadTrimController;
use App\Http\Controllers\ThemeOne\CertificateController;


Route::get('home', [HomeController::class, 'userIndex'])->name('user.home');
Route::get('dashboard',[HomeController::class, 'userIndex'])->name('admin.dashboard');
Route::get('profile',[UserController::class, 'profile'])->name('user.profile');
Route::get('password', [UserController::class, 'password'])->name('user.password');

Route::get('flying', [FlyingController::class, 'index'])->name('user.flying.index');
Route::post('flying-list', [FlyingController::class, 'list'])->name('user.flying.list');
Route::get('my-flying', [FlyingController::class, 'myFlying'])->name('user.flying.myFlying');
Route::post('my-flying-list', [FlyingController::class, 'myFlyingList'])->name('user.flying.myFlyingList');

Route::get('shortie', [FlyingController::class, 'shortie'])->name('user.flying.shortie');
Route::post('shortie-list', [FlyingController::class, 'shortieList'])->name('user.flying.shortieList');
Route::get('my-shortie', [FlyingController::class, 'myShortie'])->name('user.flying.myShortie');
Route::post('my-shortie-list', [FlyingController::class, 'myShortieList'])->name('user.flying.myShortieList');

Route::get('fdtl-report', [FDTLController::class, 'index'])->name('user.fdtl.index');
Route::get('my-fdtl-report', [FDTLController::class, 'myFdtlReport'])->name('user.fdtl.myFdtlReport');
Route::post('get-report', [FDTLController::class, 'getReport'])->name('user.fdtl.getReport');
Route::get('fdtl/report/print/{id?}/{front_date?}/{to_date?}', [FDTLController::class, 'printReport'])->name('user.fdtl.printReport');

Route::get('statistics', [FlyingController::class, 'statistics'])->name('user.flying.statistics');
Route::get('my-statistics', [FlyingController::class, 'myStatistics'])->name('user.flying.myStatistics');
Route::post('statistics-list', [FlyingController::class, 'statisticsList'])->name('user.flying.statisticsList');
Route::get('statistics/print/{from_date?}/{to_date?}/{aircraft?}/{pilot?}/{flying_type?}', [FlyingController::class, 'statisticsPrint'])->name('user.flying.statisticsPrint');

Route::get('voilations', [FDTLController::class, 'voilations'])->name('user.fdtl.voilations');
Route::get('my-voilations', [FDTLController::class, 'MyVoilations'])->name('user.fdtl.MyVoilations');
Route::post('voilations-list', [FDTLController::class, 'voilationsList'])->name('user.fdtl.voilationsList');

Route::get('/flying/verify/{id}',[FlyingController::class, 'verify'])->name('user.flying.verify');

Route::get('sfa/sfa-generate', [SFAController::class, 'sfaGenerate'])->name('user.sfa.sfaGenerate');
Route::get('sfa/my-sfa-generate', [SFAController::class, 'mySfaGenerate'])->name('user.sfa.mySfaGenerate');
Route::post('sfa-store', [SFAController::class, 'sfaStore'])->name('user.sfa.sfaStore');

Route::get('sfa/sfa-list', [SFAController::class, 'sfaList'])->name('user.sfa.sfaList');
Route::get('sfa/my-sfa-list', [SFAController::class, 'mySfaList'])->name('user.sfa.mySfaList');
Route::post('get-sfa-list', [SFAController::class, 'getSfaList'])->name('user.sfa.getSfaList');
Route::post('sfa-flying-list', [SFAController::class, 'list'])->name('user.sfa.flyinglist');
Route::get('/sfa/view/{id}', [SFAController::class, 'sfaView'])->name('user.sfa.view');
Route::get('/sfa/delete/{id}', [SFAController::class, 'sfaDelete'])->name('user.sfa.deleted');
Route::get('/sfa/verify/{id}',[SFAController::class, 'verify'])->name('user.sfa.verify');
Route::get('/sfa/approved/{id}',[SFAController::class, 'approved'])->name('user.sfa.approved');
Route::get('/sfa/download/{id}', [SFAController::class, 'downloadSfaReport'])->name('user.sfa.download');

Route::prefix('load-trim')->group(function () {
    Route::get('/', [LoadTrimController::class, 'index'])->name('user.loadTrim');
    Route::get('/add', [LoadTrimController::class, 'apply'])->name('user.loadTrim.add');
    Route::post('list', [LoadTrimController::class, 'list'])->name('user.loadTrim.list');
    Route::post('store', [LoadTrimController::class, 'store'])->name('user.loadTrim.store');
    Route::get('edit/{id}', [LoadTrimController::class, 'edit'])->name('user.loadTrim.edit');
    Route::post('update/{id}', [LoadTrimController::class, 'update'])->name('user.loadTrim.update');
    Route::get('cancel/{id}', [LoadTrimController::class, 'cancelled'])->name('user.loadTrim.cancelled');
});

Route::group(['prefix' => 'certificate'], function () {

    Route::get('licence', [CertificateController::class, 'licence'])->name('user.certificate.licence');
    Route::get('my-licence', [CertificateController::class, 'myLicence'])->name('user.certificate.myLicence');
    Route::post('licence-list', [CertificateController::class, 'licenceList'])->name('user.certificate.licenceList');
    Route::get('trainings', [CertificateController::class, 'trainings'])->name('user.certificate.trainings');
    Route::get('my-trainings', [CertificateController::class, 'myTrainings'])->name('user.certificate.myTrainings');
    Route::post('training-list', [CertificateController::class, 'trainingList'])->name('user.certificate.trainingList');
    Route::get('medicals', [CertificateController::class, 'medicals'])->name('user.certificate.medicals');
    Route::get('my-medicals', [CertificateController::class, 'myMedicals'])->name('user.certificate.myMedicals');
    Route::post('medical-list', [CertificateController::class, 'medicalList'])->name('user.certificate.medicalList');
    Route::get('qualifications', [CertificateController::class, 'qualifications'])->name('user.certificate.qualifications');
    Route::get('my-qualifications', [CertificateController::class, 'myQualifications'])->name('user.certificate.myQualifications');
    Route::post('qualification-list', [CertificateController::class, 'qualificationList'])->name('user.certificate.qualificationList');
    Route::get('ground-trainings', [CertificateController::class, 'groundTrainings'])->name('user.certificate.groundTrainings');
    Route::get('my-ground-trainings', [CertificateController::class, 'myGroundTrainings'])->name('user.certificate.myGroundTrainings');
    Route::post('ground-training-list', [CertificateController::class, 'groundTrainingList'])->name('user.certificate.groundTrainingList');

    Route::get('{type}/{user_id}/{id}', [CertificateController::class, 'viewLogs'])->name('user.certificate.viewLogs');
    Route::post('get-log-list', [CertificateController::class, 'getLogList'])->name('user.certificate.getLogList');
});
Route::post('/certificate/view', [CertificateController::class, 'viewData'])->name('user.ltm.view');

Route::prefix('reports')->group(function () {

    Route::get('external-flying', [ReportsController::class, 'externalFlying'])->name('user.reports.externalFlying');
    Route::post('external-flying-list', [ReportsController::class, 'externalFlyingList'])->name('user.reports.externalFlyingList');
    Route::get('external-flying-print/{from_date?}/{to_date?}/{aircraft?}/{flying_type?}', [ReportsController::class, 'externalFlyingPrint'])->name('user.reports.externalFlyingPrint');

    Route::get('pilot-flying-hours', [ReportsController::class, 'pilotFlyingHours'])->name('user.reports.pilotFlyingHours');
    Route::get('pilot-flying-hours-print/{from_date?}/{to_date?}', [ReportsController::class, 'pilotFlyingHoursPrint'])->name('user.reports.flyingHoursPrint');
    Route::get('aircraft-wise-summary-print/{from_date?}/{to_date?}', [ReportsController::class, 'aircraftWiseSummaryPrint'])->name('user.reports.aircraftWiseSummaryPrint');

    Route::get('pilot-ground-training', [ReportsController::class, 'pilotGroundTraining'])->name('user.reports.pilotGroundTraining');
    Route::get('pilot-ground-training-print/{date?}/{aircraft?}', [ReportsController::class, 'pilotGroundTrainingPrint'])->name('user.reports.pilotGroundTrainingPrint');

    Route::get('vip-recency', [ReportsController::class, 'vipRecency'])->name('user.reports.vipRecency');
    Route::get('vip-recency-print/{date?}/{aircraft_type?}', [ReportsController::class, 'vipRecencyPrint'])->name('user.reports.vipRecencyPrint');

    Route::get('/voilations/report', [FDTLController::class, 'voilationsReport'])->name('user.fdtl.voilations.report');
    Route::post('/voilations/report/list', [FDTLController::class, 'voilationsReportList'])->name('user.fdtl.voilations.report.list');

    Route::post('/voilation-details', [FDTLController::class, 'voilationDetails'])->name('user.fdtl.violation-details');
    Route::post('/update-exception', [FDTLController::class, 'updateException'])->name('user.fdtl.updateException');

    Route::post('/voilation-update', [FDTLController::class, 'voilationUpdate'])->name('user.fdtl.violation-update');
    Route::post('/update-re-update', [FDTLController::class, 'voilationReUpdate'])->name('user.fdtl.update.re-update');



    Route::get('aai-reports', [ReportsController::class, 'aaiReports'])->name('user.reports.aaiReports');
    Route::post('list', [AaiController::class, 'list'])->name('user.aai_report.list');
});

Route::get('/flying-currency', [ReportsController::class, 'flyingCurrency'])->name('user.reports.pilotFlyingCurrency');
Route::get('/flying-currency-print/{date?}/{aircraft?}/{report_type?}', [ReportsController::class, 'pilotFlyingCurrencyPrint'])->name('user.reports.pilotFlyingCurrencyPrint');
Route::get('/flying-test-details-print/{date?}', [ReportsController::class, 'FlyingTestDetailsPrint'])->name('user.reports.FlyingTestDetailsPrint');
Route::get('/training-and-checks-print/{date?}/{aircraft?}', [ReportsController::class, 'trainingChecksPrint'])->name('user.reports.trainingChecksPrint');

Route::prefix('my-leave')->group(function () {
    Route::get('/', [MyLeaveController::class, 'index'])->name('user.my.leave');
    Route::get('/apply', [MyLeaveController::class, 'apply'])->name('user.my.leave.apply');
    Route::post('list', [MyLeaveController::class, 'list'])->name('user.my.leave.list');
    Route::post('store', [MyLeaveController::class, 'store'])->name('user.my.leave.store');
    Route::get('edit/{id}', [MyLeaveController::class, 'edit'])->name('user.my.leave.edit');
    Route::post('update/{id}', [MyLeaveController::class, 'update'])->name('user.my.leave.update');
    Route::get('cancel/{id}', [MyLeaveController::class, 'cancelled'])->name('user.my.leave.cancelled');
});
Route::get('/contract', [ContractController::class, 'index'])->name('user.contract');
Route::post('/contract', [ContractController::class, 'list'])->name('user.contract');

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.users');
    Route::get('create', [UserController::class, 'create'])->name('user.users.create');
    Route::post('store', [UserController::class, 'store'])->name('user.users.store');
    Route::post('list', [UserController::class, 'list'])->name('user.users.list');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.users.edit');
    Route::put('update/{id}', [UserController::class, 'update'])->name('user.users.update');
    Route::post('change/status', [UserController::class, 'updateStatus'])->name('user.users.status');
    Route::get('destroy/{id}', [UserController::class, 'destroy'])->name('user.users.destroy');


    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('profile/update', [UserController::class, 'profileUpdate'])->name('user.profile.update');
    Route::get('password', [UserController::class, 'password'])->name('user.password');
    Route::put('password/update', [UserController::class, 'passwordUpdate'])->name('user.password.update');
    Route::post('get-user-by-section', [UserController::class,'getUserBySection'])->name('user.getUserBySection');

});

Route::group(['prefix' => 'aircrafts'], function () {
    Route::get('/', [AirCraftController::class, 'index'])->name('user.aircrafts');
    Route::post('list', [AirCraftController::class, 'list'])->name('user.aircraft.list');
    Route::get('create', [AirCraftController::class, 'create'])->name('user.aircraft.create');
    Route::post('store', [AirCraftController::class, 'store'])->name('user.aircraft.store');
    Route::get('edit/{id}', [AirCraftController::class, 'edit'])->name('user.aircraft.edit');
    Route::put('update/{id}', [AirCraftController::class, 'update'])->name('user.aircraft.update');
    Route::get('destroy/{id}', [AirCraftController::class, 'destroy'])->name('user.aircraft.destroy');

});




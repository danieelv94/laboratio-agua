<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudyRequestController;
use App\Http\Controllers\CeaaStaffController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/solicitud/nueva', [StudyRequestController::class, 'create'])->name('solicitud.nueva');
Route::post('/solicitud/nueva', [StudyRequestController::class, 'store'])->name('solicitud.guardar');
Route::get('/solicitud/buscar', [StudyRequestController::class, 'statusForm'])->name('solicitud.buscar');
Route::post('/solicitud/buscar', [StudyRequestController::class, 'checkStatus'])->name('solicitud.buscar.procesar');
Route::get('/solicitud/{reference}', [StudyRequestController::class, 'show'])->name('solicitud.ver');
Route::post('/solicitud/{reference}/comprobante', [StudyRequestController::class, 'uploadVoucher'])->name('solicitud.comprobante');
Route::post('/solicitud/{reference}/encuesta', [StudyRequestController::class, 'submitSurvey'])->name('solicitud.encuesta');

// Administrative routes (CEAA Staff)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CeaaStaffController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/solicitud/{studyRequest}', [CeaaStaffController::class, 'show'])->name('dashboard.solicitud');
    Route::get('/dashboard/metricas', [CeaaStaffController::class, 'metrics'])
        ->middleware('role:admin,laboratorio')
        ->name('dashboard.metricas');
    
    // Actions restricted by role
    Route::post('/dashboard/solicitud/{studyRequest}/actualizar', [CeaaStaffController::class, 'update'])
        ->middleware('role:admin,laboratorio')
        ->name('dashboard.solicitud.actualizar');

    Route::post('/dashboard/solicitud/{studyRequest}/factura', [CeaaStaffController::class, 'uploadInvoice'])
        ->middleware('role:admin,administracion')
        ->name('dashboard.solicitud.factura');
});

require __DIR__.'/auth.php';

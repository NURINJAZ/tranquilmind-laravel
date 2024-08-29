<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AppointmentsController;
//use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\PatientController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DocsController::class, 'index'])->name('dashboard');
    //Route::get('/dashboardC', [AppointmentsController::class, 'dashboardC'])->name('dashboardC');
    //Route::get('/dashboard', [PatientController::class, 'updatePatientsCount'])->name('dashboard');
});


//Route::resource('admin/appointments', AppointmentController::class);



//Display a listing of the appointments
Route::get('admin/appointments', [DocsController::class, 'index123'])->name('admin.appointments.index');
Route::get('admin/patients', [PatientController::class, 'index'])->name('admin.patients.index');

Route::patch('admin/appointments/{appointment}/status', [DocsController::class, 'updateStatus'])->name('admin.appointments.updateStatus');
Route::patch('admin/patients/{appointment}/status', [DocsController::class, 'updateStatusPatient'])->name('admin.patients.updateStatusPatient');



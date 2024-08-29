<?php

use App\Models\Appointments;
use App\Models\Doctor;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\DassController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [UsersController::class, 'login']);
Route::post('/register', [UsersController::class, 'register']);

//this group mean return user's data if authenticated successfully
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [UsersController::class, 'index']);
    Route::post('/update', [UsersController::class, 'updateProfile']);
    Route::post('/fav', [UsersController::class, 'storeFavDoc']);
    Route::post('/logout', [UsersController::class, 'logout']);
    Route::post('/book', [AppointmentsController::class, 'store']);
    Route::post('/reviews', [DocsController::class, 'store']);
    Route::get('/rating/{docId}', [DocsController::class, 'getDoctorRating']);
    Route::get('/admin-location/{docId}', [DocsController::class, 'getAdminLocation']);
    Route::post('/dass', [DassController::class, 'store']);
    Route::get('/viewdass', [DassController::class, 'getUserDassResults']);
    Route::get('/appointments', [AppointmentsController::class, 'index']);
    Route::post('/reschedule', [AppointmentsController::class, 'reschedule']);
    Route::post('/cancel', [AppointmentsController::class, 'cancel']);
}); 


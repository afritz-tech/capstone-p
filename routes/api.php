<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\LaboratoryTestController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User Controller
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user}', [UserController::class, 'update']);

//Address Controller
Route::post('/addresses', [AddressController::class, 'store']);
Route::put('/addresses/{address}', [AddressController::class, 'update']);

//Phone Number Controller
Route::post('/phone-numbers', [PhoneNumberController::class, 'store']);
Route::put('/phone-numbers/{phoneNumber}', [PhoneNumberController::class, 'update']);

//Insurance Controller
Route::post('/insurances', [InsuranceController::class, 'store']);
Route::put('/insurances/{insurance}', [InsuranceController::class, 'update']);

//Appointment Controller
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::put('/appointments/{appointment}', [AppointmentController::class, 'update']);

//Medical Record Controller
Route::post('/medical-records', [MedicalRecordController::class, 'store']);
Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update']);

//Laboratory Test Controller
Route::post('/laboratory-tests', [LaboratoryTestController::class, 'store']);
Route::put('/laboratory-tests/{laboratoryTest}', [LaboratoryTestController::class, 'update']);


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\AppointmentController;

Route::get('/patients', [PatientController::class, 'index']);
Route::get('/patients/{id}', [PatientController::class, 'show']);
Route::put('/patients/{id}', [PatientController::class, 'update']);

Route::get('/appointments', [AppointmentController::class, 'getAllAppointments']);
Route::get('/appointments/{id}', [AppointmentController::class, 'getAppointmentById']);

Route::get('/prescriptions/patient/{id}', [PrescriptionController::class, 'getPrescriptionsByPatient']);

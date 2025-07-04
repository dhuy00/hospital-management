<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/patients', [\App\Http\Controllers\PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/{id}', [\App\Http\Controllers\PatientController::class, 'show'])->name('patients.show');

Route::get('/patients/{patientId}/records/{recordId}/prescription', [\App\Http\Controllers\PatientController::class, 'prescriptionDetail'])->name('patients.prescription');

Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments/search-doctors', [AppointmentController::class, 'searchDoctors'])->name('appointments.searchDoctors');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
Route::get('/appointments/{id}/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
Route::post('/appointments/{id}/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');

Route::get('/prescriptions/{id}/edit', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
Route::put('/prescriptions/{id}', [PrescriptionController::class, 'update'])->name('prescriptions.update');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifications/appointments', [NotificationController::class, 'showReminders'])->name('notifications.appointments');
Route::post('/notifications/appointment-email', [NotificationController::class, 'sendAppointmentReminder'])->name('notifications.sendAppointmentReminder');
Route::post('/notifications/appointment-sms', [NotificationController::class, 'sendAppointmentReminderSms'])->name('notifications.sendAppointmentReminderSms');
Route::post('/notifications/prescription-email', [NotificationController::class, 'sendPrescriptionReady'])->name('notifications.sendPrescriptionReady');
Route::post('/notifications/prescription-sms', [NotificationController::class, 'sendPrescriptionReadySms'])->name('notifications.sendPrescriptionReadySms');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');


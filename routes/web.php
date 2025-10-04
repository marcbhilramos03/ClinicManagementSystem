<?php

use App\Models\Program;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicStaffController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\ClinicPatientController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\ClinicStaffProfileController;

// Homepage
Route::get('/', fn() => view('homepage'))->name('home');

// -----------------------------
// Auth
// -----------------------------
Route::post('/register', [UsersController::class, 'register'])->name('register');
Route::post('/login', [UsersController::class, 'login'])->name('login');
Route::post('/logout', [UsersController::class, 'logout'])->name('logout');

// -----------------------------
// Common routes (authenticated)
// -----------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/department/{id}/programs', [PersonalInformationController::class, 'programs']);
});


Route::prefix('patient')->name('patient.')->middleware(['auth','role:patient','check.profile'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');

    // Patient Profile
    // Profile routes
    Route::get('/profile', [PatientProfileController::class, 'show'])->name('profile.view');
    Route::get('/profile/edit', [PatientProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PatientProfileController::class, 'update'])->name('profile.update');

    Route::get('/patient/get-programs/{department}', [PersonalInformationController::class, 'getPrograms'])->name('patient.getPrograms');

    // Appointments
    Route::get('/appointments', [PatientController::class, 'myAppointments'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Records & Notifications
    Route::get('/records', [PatientController::class, 'records'])->name('records');
    Route::get('/notifications', [PatientController::class, 'notifications'])->name('notifications');
});




Route::middleware(['auth', 'role:clinic_staff'])->prefix('clinic-staff')->name('clinic_staff.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ClinicStaffController::class, 'dashboard'])->name('dashboard');

   // Profile view
    Route::get('/profile', [ClinicStaffProfileController::class, 'profile'])->name('profile.view');

    // Profile edit
    Route::get('/profile/edit', [ClinicStaffProfileController::class, 'edit'])->name('profile.edit');

    // Profile update
    Route::put('/profile/update', [ClinicStaffProfileController::class, 'update'])->name('profile.update');
    // Appointments
    Route::get('/appointments', [ClinicStaffController::class, 'appointments'])->name('appointments');
    Route::patch('/appointments/{appointment}/status', [ClinicStaffController::class, 'updateAppointmentStatus'])->name('appointments.updateStatus');
    Route::delete('/appointments/{appointment}', [ClinicStaffController::class, 'destroyAppointment'])->name('appointments.destroy');

    // Inventory
    Route::get('/inventories/medicine', [ClinicStaffController::class, 'medicineInventory'])->name('inventories.medicine');
    Route::get('/inventories/equipment', [ClinicStaffController::class, 'equipmentInventory'])->name('inventories.equipment');

     // Patients
    Route::get('/patients', [ClinicPatientController::class, 'index'])->name('patients.index');

    // Medical Record
    Route::get('/patients/medical-record/create', [ClinicPatientController::class, 'createMedicalRecord'])->name('patients.medical_record.create');
    Route::post('/patients/medical-record', [ClinicPatientController::class, 'storeMedicalRecord'])->name('patients.medical_record.store');

    // Vitals
    Route::get('/patients/vitals/create', [ClinicPatientController::class, 'createVitals'])->name('patients.vitals.create');
    Route::post('/patients/vitals', [ClinicPatientController::class, 'storeVitals'])->name('patients.vitals.store');
});



// -----------------------------
// Admin routes
// -----------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

    Route::get('/manageUsers', [AdminController::class, 'manageUsers'])->name('manageUsers');
    Route::post('/users/create', [UsersController::class, 'createUser'])->name('users.create');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Inventory
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/medicine', [InventoriesController::class, 'medicines'])->name('medicine');
        Route::get('/equipment', [InventoriesController::class, 'equipment'])->name('equipment');
        Route::post('/store', [InventoriesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [InventoriesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InventoriesController::class, 'update'])->name('update');
        Route::delete('/{id}', [InventoriesController::class, 'destroy'])->name('destroy');
        Route::get('/archived', [InventoriesController::class, 'expired'])->name('archived');
    });
});

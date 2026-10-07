<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role == 'super_admin') {
        return redirect('/super-admin/dashboard');
    } elseif (auth()->user()->role == 'doctor') {
        return redirect('/doctor/dashboard');
    } elseif (auth()->user()->role == 'user') {
        return redirect('/patient/dashboard');
    }
    return redirect('/login');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role based routes
// Super Admin Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');
    
    // Doctor Management
    Route::resource('doctors', DoctorController::class);
    
    // Patient Management  
    Route::resource('patients', PatientController::class);
    
    // Appointments
    Route::get('appointments', [AppointmentController::class, 'index'])->name('super-admin.appointments');
    Route::get('appointments/create', [AppointmentController::class, 'createAppointment'])->name('super-admin.appointments.create');
    Route::post('appointments/store', [AppointmentController::class, 'storeAppointment'])->name('super-admin.appointments.store');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/appointments', [AppointmentController::class, 'doctorAppointments'])->name('doctor.appointments');
    Route::get('/prescription/create/{appointment}', [PrescriptionController::class, 'create'])->name('doctor.prescription.create');
    Route::post('/prescription/store', [PrescriptionController::class, 'store'])->name('doctor.prescription.store');
    Route::get('/prescriptions', [PrescriptionController::class, 'doctorPrescriptions'])->name('doctor.prescriptions');
    Route::get('/prescription/{prescription}', [PrescriptionController::class, 'show'])->name('prescription.show');
    Route::get('/prescription/edit/{prescription}', [PrescriptionController::class, 'edit'])->name('doctor.prescription.edit');
Route::put('/prescription/update/{prescription}', [PrescriptionController::class, 'update'])->name('doctor.prescription.update');
});

// Patient Routes
Route::middleware(['auth', 'role:user'])->prefix('patient')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/appointments', [AppointmentController::class, 'patientAppointments'])->name('patient.appointments');
    Route::get('/book-appointment', [AppointmentController::class, 'create'])->name('patient.book-appointment');
    Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('patient.appointments.store');
    Route::get('/medical-history', [PatientController::class, 'medicalHistory'])->name('patient.history');
});

require __DIR__.'/auth.php';
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// PUBLIC ROUTE - Available slots (No middleware)
Route::post('/get-available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('get.available.slots');
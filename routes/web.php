<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\TrialController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/program/pdi', function () {
    return view('programs.pdi');
})->name('program.pdi');

Route::get('/program/pds', function () {
    return view('programs.pds');
})->name('program.pds');

Route::get('/program/pbm', function () {
    return view('programs.pbm');
})->name('program.pbm');

Route::get('/kurikulum/level-1', function () {
    return view('kurikulum.level-1');
})->name('kurikulum.level-1');

Route::get('/kurikulum/level-2', function () {
    return view('kurikulum.level-2');
})->name('kurikulum.level-2');

Route::get('/kurikulum/level-3', function () {
    return view('kurikulum.level-3');
})->name('kurikulum.level-3');

Route::get('/kurikulum/level-4', function () {
    return view('kurikulum.level-4');
})->name('kurikulum.level-4');

// Redirects for old routes
Route::redirect('/program/tk-ra', '/program/pdi');
Route::redirect('/program/sd-mi', '/program/pds');
Route::redirect('/program/smp-mts', '/program/pbm');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');


    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    // Registration Routes
    Route::get('/registration/create', [RegistrationController::class, 'create'])->name('registration.create');
    
    // Step 1: Data Diri
    Route::get('/registration/{student}/data', [RegistrationController::class, 'step1'])->name('registration.data');
    Route::post('/registration/data', [RegistrationController::class, 'storeStep1'])->name('registration.store_data');

    // Step 2: Class Selection
    Route::get('/registration/{student}/class', [RegistrationController::class, 'step4'])->name('registration.class');
    Route::post('/registration/{student}/class', [RegistrationController::class, 'storeStep4'])->name('registration.store_class');

    Route::get('/payment/{student}', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/{student}', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/{student}/proof', [PaymentController::class, 'printProof'])->name('payment.print-proof');

    Route::get('/my-student/{student}', [StudentController::class, 'show'])->name('student.show');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/student/create', [AdminController::class, 'create'])->name('create');
    Route::post('/student/store', [AdminController::class, 'store'])->name('store');
    Route::get('/student/{student}', [AdminController::class, 'show'])->name('show');
    Route::get('/student/{student}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/student/{student}', [AdminController::class, 'update'])->name('update');
    Route::delete('/student/bulk-destroy', [AdminController::class, 'bulkDestroy'])->name('bulkDestroy');
    Route::delete('/student/{student}', [AdminController::class, 'destroy'])->name('destroy');
    Route::post('/student/{student}/verify', [AdminController::class, 'verify'])->name('verify');
    Route::post('/student/{student}/validate-payment', [AdminController::class, 'validatePayment'])->name('validatePayment');
    Route::put('/student/{student}/payment-details', [AdminController::class, 'updatePaymentDetails'])->name('updatePaymentDetails');
    Route::post('/student/{student}/activate', [AdminController::class, 'activate'])->name('activate');
    
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
    Route::get('/classes/{class}/edit', [ClassController::class, 'edit'])->name('classes.edit');
    Route::put('/classes/{class}', [ClassController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{class}', [ClassController::class, 'destroy'])->name('classes.destroy');
    


    Route::get('/reports/active-students-csv', [AdminController::class, 'exportCsv'])->name('reports.csv');
    Route::delete('/students/delete-all', [AdminController::class, 'deleteAll'])->name('students.delete-all');
    
    // Trial Management
    Route::get('/trials', [TrialController::class, 'index'])->name('trials.index');
    Route::put('/trials/{trial}', [TrialController::class, 'update'])->name('trials.update');
    Route::delete('/trials/{trial}', [TrialController::class, 'destroy'])->name('trials.destroy');
});

// Public Trial Routes
Route::get('/trial/register', [TrialController::class, 'create'])->name('trial.create');
Route::post('/trial/register', [TrialController::class, 'store'])->name('trial.store');
Route::get('/trial/success', [TrialController::class, 'success'])->name('trial.success');


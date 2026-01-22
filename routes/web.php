<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\PengumpulanController;
use App\Http\Controllers\LabController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])
    ->middleware(['guest', 'rate.limit:register_user,5,24']); // Max 5 registrations per 24 hours

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/connect-google', [App\Http\Controllers\ProfileController::class, 'connectGoogle'])->name('profile.connect-google');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');
    
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [KelasController::class, 'store'])
        ->name('kelas.store')
        ->middleware('rate.limit:create_kelas,3,48'); // Max 3 classes per 48 hours
    Route::get('/kelas/join', [KelasController::class, 'join'])->name('kelas.join');
    Route::post('/kelas/join', [KelasController::class, 'storeJoin'])->name('kelas.join.store');
    Route::get('/kelas/{kodeUnik}', [KelasController::class, 'show'])->name('kelas.show');
    Route::get('/kelas/{kodeUnik}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{kodeUnik}', [KelasController::class, 'update'])->name('kelas.update');
    Route::get('/kelas/{kodeUnik}/members', [KelasController::class, 'members'])->name('kelas.members');
    Route::delete('/kelas/{kodeUnik}/members/{userId}', [KelasController::class, 'removeMember'])->name('kelas.removeMember');
    Route::delete('/kelas/{kodeUnik}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    
    Route::get('/tugas/create/{kelasId}', [TugasController::class, 'create'])->name('tugas.create');
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('/tugas/{id}', [TugasController::class, 'show'])->name('tugas.show');
    Route::get('/tugas/{id}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
    Route::get('/tugas/{id}/nilai', [TugasController::class, 'nilai'])->name('tugas.nilai');
    Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');
    
    // Lab Routes
    Route::get('/lab', [LabController::class, 'index'])->name('lab.index');
    Route::get('/lab/create/{kelasId}', [LabController::class, 'create'])->name('lab.create');
    Route::post('/lab', [LabController::class, 'store'])->name('lab.store');
    Route::get('/lab/{id}', [LabController::class, 'show'])->name('lab.show');
    Route::get('/lab/{id}/edit', [LabController::class, 'edit'])->name('lab.edit');
    Route::put('/lab/{id}', [LabController::class, 'update'])->name('lab.update');
    Route::post('/lab/{id}/submit', [LabController::class, 'submit'])->name('lab.submit');
    Route::get('/lab/{id}/submissions', [LabController::class, 'submissions'])->name('lab.submissions');
    Route::delete('/lab/submissions/{id}', [LabController::class, 'destroySubmission'])->name('lab.submissions.destroy');
    Route::delete('/lab/{id}', [LabController::class, 'destroy'])->name('lab.destroy');
    
    // Modul Routes
    Route::get('/kelas/{kelasId}/modul', [App\Http\Controllers\ModulController::class, 'index'])->name('modul.index');
    Route::get('/kelas/{kelasId}/modul/create', [App\Http\Controllers\ModulController::class, 'create'])->name('modul.create');
    Route::post('/kelas/{kelasId}/modul', [App\Http\Controllers\ModulController::class, 'store'])->name('modul.store');
    Route::get('/modul/{modulId}', [App\Http\Controllers\ModulController::class, 'show'])->name('modul.show');
    Route::get('/modul/{modulId}/edit', [App\Http\Controllers\ModulController::class, 'edit'])->name('modul.edit');
    Route::put('/modul/{modulId}', [App\Http\Controllers\ModulController::class, 'update'])->name('modul.update');
    Route::delete('/modul/{modulId}', [App\Http\Controllers\ModulController::class, 'destroy'])->name('modul.destroy');
    Route::post('/modul/reorder', [App\Http\Controllers\ModulController::class, 'reorder'])->name('modul.reorder');
    
    // Sub-Modul Routes
    Route::get('/modul/{modulId}/sub-modul/create', [App\Http\Controllers\SubModulController::class, 'create'])->name('sub-modul.create');
    Route::post('/modul/{modulId}/sub-modul', [App\Http\Controllers\SubModulController::class, 'store'])->name('sub-modul.store');
    Route::get('/sub-modul/{subModulId}', [App\Http\Controllers\SubModulController::class, 'show'])->name('sub-modul.show');
    Route::get('/sub-modul/{subModulId}/edit', [App\Http\Controllers\SubModulController::class, 'edit'])->name('sub-modul.edit');
    Route::put('/sub-modul/{subModulId}', [App\Http\Controllers\SubModulController::class, 'update'])->name('sub-modul.update');
    Route::delete('/sub-modul/{subModulId}', [App\Http\Controllers\SubModulController::class, 'destroy'])->name('sub-modul.destroy');
    Route::post('/sub-modul/{subModulId}/complete', [App\Http\Controllers\SubModulController::class, 'markComplete'])->name('sub-modul.complete');
    
    // Image upload for editor
    Route::post('/api/upload-image', [App\Http\Controllers\SubModulController::class, 'uploadImage'])->name('api.upload-image');
    
    Route::get('/pengumpulan/create/{tugasId}', [PengumpulanController::class, 'create'])->name('pengumpulan.create');
    Route::post('/pengumpulan', [PengumpulanController::class, 'store'])->name('pengumpulan.store');
    Route::put('/pengumpulan/{id}', [PengumpulanController::class, 'update'])->name('pengumpulan.update');
    Route::get('/pengumpulan/{id}/download', [PengumpulanController::class, 'download'])->name('pengumpulan.download');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'The [public/storage] directory has been linked.'; 
});

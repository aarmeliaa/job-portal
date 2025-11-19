<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
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
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    return "Halo Admin!";
})->middleware(['auth', 'isAdmin']);


Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
    ->middleware('auth')
    ->name('apply.store');

Route::get('jobs', [JobController::class, 'index']);

// ROUTE KHUSUS ADMIN (Tambahkan di dalam middleware auth & isAdmin)
Route::middleware(['auth', 'isAdmin'])->group(function () {
    
    // Route Resource untuk CRUD Jobs (yang sudah ada sebelumnya)
    Route::resource('jobs', JobController::class);

    // Route Resource untuk Applications (Hanya index dan update)
    Route::resource('applications', ApplicationController::class)->only(['index', 'update']);
    
    // Route untuk Export Excel
    Route::get('/export-applications', [ApplicationController::class, 'export'])->name('applications.export');
    
    // Route untuk Import Excel
    Route::post('/import-jobs', [JobController::class, 'import'])->name('jobs.import');
});
  
require __DIR__.'/auth.php';

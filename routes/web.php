<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\CheckLinkController;
use App\Http\Controllers\SimulatorController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminModuleController;
use App\Http\Controllers\Admin\AdminResourceController;
use App\Http\Controllers\Admin\AdminUserController;

// Public routes (no auth required)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::get('/modules/{slug}', [ModuleController::class, 'show'])->name('modules.show');
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/check-link', [CheckLinkController::class, 'index'])->name('check-link.index');
Route::post('/check-link', [CheckLinkController::class, 'check'])->name('check-link.check')->middleware('throttle:10,1');
Route::get('/how-it-works', [HowItWorksController::class, 'index'])->name('how-it-works.index');
Route::get('/simulator', [SimulatorController::class, 'index'])->name('simulator.index');
Route::post('/simulator/answer', [SimulatorController::class, 'answer'])->name('simulator.answer');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::delete('/history/{history}', [HistoryController::class, 'destroy'])->name('history.destroy');
    Route::post('/history/import-guest', [HistoryController::class, 'importGuest'])->name('history.import-guest');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('modules', AdminModuleController::class);
    Route::resource('resources', AdminResourceController::class);
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
});

require __DIR__.'/auth.php';

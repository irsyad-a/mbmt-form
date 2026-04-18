<?php

use App\Http\Controllers\DashboardAuthController;
use App\Http\Controllers\DashboardRegistrationController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');

Route::prefix('dashboard')->name('dashboard.')->group(function (): void {
    Route::get('/login', [DashboardAuthController::class, 'create'])->name('login');
    Route::post('/login', [DashboardAuthController::class, 'store'])->name('login.store');

    Route::middleware('dashboard.auth')->group(function (): void {
        Route::post('/logout', [DashboardAuthController::class, 'destroy'])->name('logout');

        Route::get('/', [DashboardRegistrationController::class, 'index'])->name('registrations.index');
        Route::get('/registrations/create', [DashboardRegistrationController::class, 'create'])->name('registrations.create');
        Route::post('/registrations', [DashboardRegistrationController::class, 'store'])->name('registrations.store');
        Route::get('/registrations/export/excel', [DashboardRegistrationController::class, 'exportExcel'])->name('registrations.export.excel');
        Route::get('/registrations/export/pdf', [DashboardRegistrationController::class, 'exportPdf'])->name('registrations.export.pdf');
        Route::get('/registrations/{registration}/edit', [DashboardRegistrationController::class, 'edit'])->name('registrations.edit');
        Route::put('/registrations/{registration}', [DashboardRegistrationController::class, 'update'])->name('registrations.update');
        Route::delete('/registrations/{registration}', [DashboardRegistrationController::class, 'destroy'])->name('registrations.destroy');
    });
});

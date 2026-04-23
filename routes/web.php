<?php

use App\Http\Controllers\DashboardAuthController;
use App\Http\Controllers\DashboardFormSettingsController;
use App\Http\Controllers\DashboardRegistrationController;
use App\Http\Controllers\RegistrationController;
use App\Support\FormSettingsService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    /** @var FormSettingsService $formSettings */
    $formSettings = app(FormSettingsService::class);
    return view('welcome', [
        'formIsOpen' => $formSettings->isFormOpen(),
        'formSettings' => $formSettings->get(),
    ]);
});

Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');

Route::prefix('dashboard')->name('dashboard.')->group(function (): void {
    Route::get('/login', [DashboardAuthController::class, 'create'])->name('login');
    Route::post('/login', [DashboardAuthController::class, 'store'])->name('login.store');

    Route::middleware('dashboard.auth')->group(function (): void {
        Route::post('/logout', [DashboardAuthController::class, 'destroy'])->name('logout');

        // Registrations
        Route::get('/', [DashboardRegistrationController::class, 'index'])->name('registrations.index');
        Route::get('/registrations/create', [DashboardRegistrationController::class, 'create'])->name('registrations.create');
        Route::post('/registrations', [DashboardRegistrationController::class, 'store'])->name('registrations.store');
        Route::post('/mail/test', [DashboardRegistrationController::class, 'sendTestMail'])->name('mail.test');
        Route::get('/registrations/export/excel', [DashboardRegistrationController::class, 'exportExcel'])->name('registrations.export.excel');
        Route::get('/registrations/export/pdf', [DashboardRegistrationController::class, 'exportPdf'])->name('registrations.export.pdf');
        Route::get('/registrations/{registration}/edit', [DashboardRegistrationController::class, 'edit'])->name('registrations.edit');
        Route::put('/registrations/{registration}', [DashboardRegistrationController::class, 'update'])->name('registrations.update');
        Route::delete('/registrations/{registration}', [DashboardRegistrationController::class, 'destroy'])->name('registrations.destroy');

        // Summary sub-pages
        Route::get('/summary/faculty-map', [DashboardRegistrationController::class, 'summaryFacultyMap'])->name('summary.faculty_map');
        Route::get('/summary/allergy-map', [DashboardRegistrationController::class, 'summaryAllergyMap'])->name('summary.allergy_map');
        Route::get('/summary/ukm-transparency', [DashboardRegistrationController::class, 'summaryUkmTransparency'])->name('summary.ukm_transparency');

        // Form Settings (Buka/Tutup Form)
        Route::get('/form-settings', [DashboardFormSettingsController::class, 'index'])->name('form_settings.index');
        Route::post('/form-settings', [DashboardFormSettingsController::class, 'update'])->name('form_settings.update');
    });
});

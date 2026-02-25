<?php

use App\Http\Controllers\CalculationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'hasRole'])->group(function () {
    Route::get('/', [CrmController::class, 'welcome'])->name('dashboard');
    Route::resource('companies', CompanyController::class);
    Route::post('companies/bulk-delete', [CompanyController::class, 'bulkDelete'])->name('companies.bulk-delete');
    Route::get('/api/ares', [\App\Http\Controllers\AresController::class, 'getCompanyData'])->name('ares.lookup');

    Route::resource('calculations', CalculationController::class);
    Route::post('calculations/bulk-delete', [CalculationController::class, 'bulkDelete'])->name('calculations.bulk-delete');

    // Only admins can manage services and users (users management not yet implemented)
    Route::post('services/bulk', [ServiceController::class, 'bulkStore'])->name('services.bulk');
    Route::post('services/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('services.bulk-delete');
    Route::resource('services', ServiceController::class)->middleware('role:admin');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-company', [\App\Http\Controllers\MyCompanyController::class, 'edit'])->name('my-company.edit');
    Route::patch('/my-company', [\App\Http\Controllers\MyCompanyController::class, 'update'])->name('my-company.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/c/{token}', [CalculationController::class, 'showPublic'])->name('calculations.public');
Route::post('/c/{token}/confirm', [CalculationController::class, 'acceptPublic'])->name('calculations.confirm');

require __DIR__.'/auth.php';

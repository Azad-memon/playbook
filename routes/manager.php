<?php

use App\Http\Controllers\companyadmin\AdminController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\manager\ManagerDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'user.role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])
        ->name('manager.dashboard');

    });

Route::prefix('admin')->as('admin.')->group(function () {
     Route::resource('manager', ManagerController::class)->except(['show']);
     Route::get('company-manager/add-form/{company_id}', [AdminController::class, 'companyManagerAddForm'])->name('company-manager.add-form');
     Route::get('company-manager/edit-form/{id}', [AdminController::class, 'companyManagerEditForm'])->name('company-manager.edit-form');

    });

//  profile
Route::get('manager/profile/edit', [ManagerController::class, 'editProfile'])->name('manager.profile.edit');
Route::post('manager/profile/update', [ManagerController::class, 'updateProfile'])->name('manager.profile.update');


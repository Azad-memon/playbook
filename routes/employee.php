<?php

use App\Http\Controllers\companyadmin\AdminController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\employee\EmployeeDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'user.role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])
        ->name('employee.dashboard');
    });

Route::prefix('admin')->as('admin.')->group(function () {
    Route::resource('employee', EmployeeController::class)->except(['show']);
    Route::get('company-employee/add-form/{company_id}', [AdminController::class, 'companyEmployeeAddForm'])
        ->name('company-employee.add-form');
    Route::get('company-employee/edit-form/{id}', [AdminController::class, 'companyEmployeeEditForm'])
        ->name('company-employee.edit-form');
});

// profile
Route::get('employee/profile/edit', [EmployeeController::class, 'editProfile'])->name('employee.profile.edit');
 Route::post('employee/profile/update', [EmployeeController::class, 'updateProfile'])->name('employee.profile.update');


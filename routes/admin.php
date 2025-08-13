<?php

use App\Http\Controllers\companyadmin\AdminController;
use App\Http\Controllers\companyadmin\DashboardController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\manager\ManagerDashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/signup/{token}', [AdminController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup/{token}', [AdminController::class, 'completeSignup'])->name('signup.complete');
// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'user.role:company-admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

//company manager

//    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])
//     ->middleware(['auth','user.role:manager'])
//     ->name('manager.dashboard');
//    Route::resource('manager', ManagerController::class)->except(['show']);
//    Route::get('company-manager/add-form/{company_id}', [AdminController::class, 'companyManagerAddForm'])->name('company-manager.add-form');
//    Route::get('company-manager/edit-form/{id}', [AdminController::class, 'companyManagerEditForm'])->name('company-manager.edit-form');

 //company employee
//    Route::resource('employee', EmployeeController::class)->except(['show']);
//    Route::get('company-employee/add-form/{company_id}', [AdminController::class, 'companyEmployeeAddForm'])->name('company-employee.add-form');
//    Route::get('company-employee/edit-form/{id}', [AdminController::class, 'companyEmployeeEditForm'])->name('company-employee.edit-form');


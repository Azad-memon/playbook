<?php

use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\superadmin\SuperAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\superadmin\DashboardController;

Route::group(['middleware' => ['auth', 'user.role:super-admin']], function () {
   Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

 // company
   Route::resource('company', SuperAdminController::class)->except(['show']);
   Route::get('company/add-form', [SuperAdminController::class, 'addForm'])->name('company.add-form');
   Route::get('company/edit-form/{id}', [SuperAdminController::class, 'editForm'])->name('company.edit-form');


});


<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', [HomeController::class, 'index'])->name('home');

//user management
Route::get('/usermanagement', [UserManagementController::class, 'index'])->name('userManagement');
Route::get('/usermanagement/create', [UserManagementController::class, 'create'])->name('userManagement.create');
Route::post('/usermanagement/create', [UserManagementController::class, 'store'])->name('userManagement.store');
Route::get('/usermanagement/update/{id}', [UserManagementController::class, 'update'])->name('userManagement.update');
Route::patch('/usermanagement/update', [UserManagementController::class, 'patch'])->name('userManagement.patch');
Route::delete('/usermanagement', [UserManagementController::class, 'destroy'])->name('userManagement.destroy');
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProjectManagementController;
use App\Http\Controllers\TeamManagementController;
use App\Http\Controllers\VacationRequestManagementController;

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

//project management
Route::get('/projectmanagement', [ProjectManagementController::class, 'index'])->name('projectManagement');
Route::get('/projectmanagement/create', [ProjectManagementController::class, 'create'])->name('projectManagement.create')
    ->middleware('superuser');

Route::get('/projectmanagement/{id}', [ProjectManagementController::class, 'show'])->name('projectManagement.show');

Route::post('/projectmanagement/create', [ProjectManagementController::class, 'store'])->name('projectManagement.store')
    ->middleware('superuser');

Route::get('/projectmanagement/update/{id}', [ProjectManagementController::class, 'update'])->name('projectManagement.update');
Route::patch('/projectmanagement/update', [ProjectManagementController::class, 'patch'])->name('projectManagement.patch');

// --timovi u projektu
Route::get('projectmanagement/addteams/{id}', [ProjectManagementController::class, 'addTeams'])->name('projectManagement.addTeams'); //id je id projekta
Route::patch('projectmanagement/addTeams', [ProjectManagementController::class, 'storeTeams'])->name('projectManagement.storeTeams');
Route::patch('projectmanagement/removeteam', [ProjectManagementController::class, 'removeTeam'])->name('projectManagement.removeTeam');
// --
Route::delete('/projectmanagement', [ProjectManagementController::class, 'destroy'])->name('projectManagement.destroy')
    ->middleware('superuser');


//team management
Route::get('/teammanagement', [TeamManagementController::class, 'index'])->name('teamManagement');
Route::get('/teammanagement/create/{project_id?}', [TeamManagementController::class, 'create'])->name('teamManagement.create')
    ->middleware('superuser');

Route::post('/teammanagement/create', [TeamManagementController::class, 'store'])->name('teamManagement.store')
    ->middleware('superuser');

Route::get('/teammanagement/update/{id}', [TeamManagementController::class, 'update'])->name('teamManagement.update');
Route::patch('/teammanagement/update', [TeamManagementController::class, 'patch'])->name('teamManagement.patch');

Route::delete('/teammanagement', [TeamManagementController::class, 'destroy'])->name('teamManagement.destroy')
    ->middleware('superuser');

Route::patch('/teammanagement/removemember', [TeamManagementController::class, 'removeMember'])->name('teamManagement.removeMember')
    ->middleware('superuser');

Route::get('/teammanagement/{id}', [TeamManagementController::class, 'show'])->name('teamManagement.show');



//VACATION REQUESTS
Route::get('/vacationRequests', [VacationRequestManagementController::class, 'index'])->name('vacationRequestManagement');
Route::get('/vacationRequests/create', [VacationRequestManagementController::class, 'create'])->name('vacationRequestManagement.create');
Route::post('/vacationRequests/create', [VacationRequestManagementController::class, 'store'])->name('vacationRequestManagement.store');
Route::get('/vacationRequests/update/{id}', [VacationRequestManagementController::class, 'update'])->name('vacationRequestManagement.update');
Route::patch('/vacationRequests/update', [VacationRequestManagementController::class, 'patch'])->name('vacationRequestManagement.patch');
Route::delete('/vacationRequests', [VacationRequestManagementController::class, 'destroy'])->name('vacationRequestManagement.destroy');

Route::get('/vacationRequests/{id}', [VacationRequestManagementController::class, 'show'])->name('vacationRequestManagement.show');
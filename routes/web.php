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

//home page
Route::get('/', [HomeController::class, 'index'])->name('home');

//user management
Route::controller(UserManagementController::class)->group(function() {
    Route::get('/usermanagement', 'index')->name('userManagement');
    Route::get('/usermanagement/create', 'create')->name('userManagement.create');
    Route::post('/usermanagement/create', 'store')->name('userManagement.store');
    Route::get('/usermanagement/update/{id}', 'update')->name('userManagement.update');
    Route::patch('/usermanagement/update', 'patch')->name('userManagement.patch');
    Route::delete('/usermanagement', 'destroy')->name('userManagement.destroy');
});


//PROJECT MANAGEMENT
Route::controller(ProjectManagementController::class)->group(function() {
    Route::get('/projectmanagement', 'index')->name('projectManagement');
    Route::get('/projectmanagement/create', 'create')->name('projectManagement.create')
        ->middleware('superuser');

    Route::get('/projectmanagement/{id}', 'show')->name('projectManagement.show');

    Route::post('/projectmanagement/create', 'store')->name('projectManagement.store')
        ->middleware('superuser');

    Route::get('/projectmanagement/update/{id}', 'update')->name('projectManagement.update');
    Route::patch('/projectmanagement/update', 'patch')->name('projectManagement.patch');


    Route::get('projectmanagement/addteams/{id}', 'addTeams')->name('projectManagement.addTeams'); //id je id projekta
    Route::patch('projectmanagement/addTeams', 'storeTeams')->name('projectManagement.storeTeams');
    Route::patch('projectmanagement/removeteam', 'removeTeam')->name('projectManagement.removeTeam');
    
    Route::delete('/projectmanagement', 'destroy')->name('projectManagement.destroy')
        ->middleware('superuser');

});


//TEAM MANAGEMENT
Route::controller(TeamManagementController::class)->group(function() {
    Route::get('/teammanagement', 'index')->name('teamManagement');
    Route::get('/teammanagement/create/{project_id?}', 'create')->name('teamManagement.create')
        ->middleware('superuser');
    Route::post('/teammanagement/create', 'store')->name('teamManagement.store')
        ->middleware('superuser');
    Route::get('/teammanagement/update/{id}', 'update')->name('teamManagement.update');
    Route::patch('/teammanagement/update', 'patch')->name('teamManagement.patch');
    Route::delete('/teammanagement', 'destroy')->name('teamManagement.destroy')
        ->middleware('superuser');
    Route::patch('/teammanagement/removemember', 'removeMember')->name('teamManagement.removeMember')
        ->middleware('superuser');
    Route::get('/teammanagement/{id}', 'show')->name('teamManagement.show');
});




//VACATION REQUESTS
Route::controller(VacationRequestManagementController::class)->group(function() {
    Route::get('/vacationrequests', 'index')->name('vacationRequestManagement');
    Route::get('/vacationrequests/create', 'create')->name('vacationRequestManagement.create');
    Route::post('/vacationrequests/create', 'store')->name('vacationRequestManagement.store');
    Route::get('/vacationrequests/update/{id}', 'update')->name('vacationRequestManagement.update');
    Route::patch('/vacationrequests/update', 'patch')->name('vacationRequestManagement.patch');
    Route::delete('/vacationrequests', 'destroy')->name('vacationRequestManagement.destroy');
    Route::patch('/vacationrequests/approve', 'approve')->name('vacationRequestManagement.approval');
    Route::get('/vacationrequests/{id}', 'show')->name('vacationRequestManagement.show');
});

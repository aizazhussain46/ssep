<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('me', 'AuthController@me');
Route::post('login', 'AuthController@login');
//Route::post('register', 'AuthController@register');

Route::resource('survey', 'SurveyController');


Route::resource('users', 'AdminController');
Route::post('change_password/{id}', 'AdminController@password_change');

Route::resource('role', 'RoleController');
Route::resource('status', 'StatusController');
Route::resource('district', 'DistrictController');
Route::resource('department', 'DepartmentController');
Route::resource('job', 'JobController');
Route::get('pending_jobs', 'JobController@pending_jobs');
Route::post('approve_job/{id}', 'JobController@approve_job');
Route::get('jobs_by_department', 'JobController@jobs_by_department');
Route::get('users_by_department', 'AdminController@users_by_department');
Route::resource('assign', 'AssignController');
Route::resource('milestone', 'MilestoneController');
Route::get('milestones_by_job/{id}', 'MilestoneController@milestones_by_job');
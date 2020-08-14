<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('me', 'AuthController@me');

Route::post('login', 'AuthController@login');

// for tab user login
Route::post('btl/login', 'AuthController@btl_login');


Route::resource('user', 'UserController');
Route::post('change_password/{id}', 'UserController@change_password');
Route::resource('survey', 'SurveyController');
Route::resource('role', 'RoleController');
Route::resource('status', 'StatusController');
Route::resource('district', 'DistrictController');
Route::resource('department', 'DepartmentController');
Route::resource('job', 'JobController');
Route::get('jobs_by_assigned_user/{id}', 'JobController@jobs_by_assigned_user');
Route::get('jobs_by_created_user/{id}', 'JobController@jobs_by_created_user');
Route::get('jobs_for_pmu', 'JobController@jobs_for_pmu');
Route::get('jobs_for_client', 'JobController@jobs_for_client');
Route::get('btl_records', 'JobController@btl_records');
Route::post('update_job/{id}', 'JobController@update_job');
Route::get('send_to_pmu/{id}', 'JobController@send_to_pmu');
Route::post('update_attachment/{id}', 'JobController@update_attachment');


Route::resource('revision', 'RevisionController');
Route::post('revision/{id}', 'RevisionController@revision');

//Route::post('change_attachment/{id}', 'JobController@change_attachment');



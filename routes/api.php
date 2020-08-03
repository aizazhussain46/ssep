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
Route::post('update_job/{id}', 'JobController@update_job');

Route::resource('revision', 'RevisionController');


//Route::post('change_attachment/{id}', 'JobController@change_attachment');



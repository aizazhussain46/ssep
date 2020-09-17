<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('me', 'AuthController@me');

Route::post('login', 'AuthController@login');

// for tab user login
Route::post('btl/login', 'AuthController@btl_login');

Route::get('demo', function(){
    echo "Api working";
});
Route::resource('user', 'UserController');
Route::get('admins', 'UserController@admins');
Route::get('user_2be_assigned/{id}/{master}/{role_id?}', 'UserController@user_2be_assigned');
Route::post('change_password/{id}', 'UserController@change_password');
Route::resource('survey', 'SurveyController');
Route::get('survey_by_job/{job_id}', 'SurveyController@survey_by_job');
Route::resource('role', 'RoleController');
Route::resource('status', 'StatusController');
Route::resource('district', 'DistrictController');
Route::resource('department', 'DepartmentController');
Route::get('dept_ex_btl', 'DepartmentController@departments_except_btl');
Route::resource('job', 'JobController');
Route::get('jobs_by_assigned_user/{id}', 'JobController@jobs_by_assigned_user');
Route::get('jobs_by_created_and_assigned/{id}', 'JobController@jobs_by_created_and_assigned');
Route::get('jobs_for_pmu', 'JobController@jobs_for_pmu');
Route::get('jobs_for_client', 'JobController@jobs_for_client');
Route::get('approve_reject/{job_id}/{action}', 'JobController@approve_reject');

Route::get('get_job_count/{id?}', 'JobController@get_job_count');


Route::get('btl_records', 'JobController@btl_records');
Route::post('update_job/{id}', 'JobController@update_job');
Route::post('share/{id}', 'JobController@share');
Route::post('update_attachment/{id}', 'JobController@update_attachment');
Route::post('change_status/{id}', 'JobController@change_status');


Route::resource('revision', 'RevisionController');
Route::post('revisions/{id}', 'RevisionController@revision');

//Route::post('change_attachment/{id}', 'JobController@change_attachment');



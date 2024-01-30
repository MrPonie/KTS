<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// guest
Route::get('/', function () {return view('home');});
Route::get('/login', function () {return view('login');});
Route::get('/respond', function () {return view('login');});

// respondent
Route::get('/respondent', function () {return view('respondent.dashboard');});
Route::get('/respondent/profile', function () {return view('respondent.profile');});
Route::get('/respondent/assigned', function () {return view('respondent.assigned_tests');});
Route::get('/respondent/respond', function () {return view('respondent.test_respond');});
Route::get('/respondent/results', function () {return view('respondent.test_results');});

// creator
Route::get('/creator', function () {return view('creator.dashboard');});
Route::get('/creator/profile', function () {return view('creator.profile');});
Route::get('/creator/question_bank', function () {return view('creator.question_bank');});
Route::get('/creator/test-form-vault', function () {return view('creator.test_form_vault');});
Route::get('/creator/assigned-users', function () {return view('creator.assigned_users');});
Route::get('/creator/tests', function () {return view('creator.tests');});
Route::get('/creator/test-results', function () {return view('creator.tests');});

// admin
Route::get('/admin', function () {return view('admin.dashboard');});
Route::get('/admin/login', function () {return view('admin.login');});
Route::get('/admin/profile', function () {return view('admin.profile');});
Route::get('/admin/respondent', function () {return view('admin.respondent');});
Route::get('/admin/creators', function () {return view('admin.creators');});
Route::get('/admin/tests', function () {return view('admin.tests');});
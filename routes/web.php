<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\Auth\AdministratorAuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\StudentAuthController;

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

// Route::get('/login', function () {return view('login');});
// Route::get('/respond', function () {return view('login');});

Route::prefix('student')->group(function() {
    Route::middleware('guard.redirect:student')->group(function() {
        Route::get('/login', [StudentController::class, 'login'])->name('student.login');
        Route::post('/login', [StudentAuthController::class, 'login']);
    });    
    Route::get('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
    
    Route::middleware(['auth:student'])->group(function() {
        Route::get('/', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    });
});
// // respondent
// Route::get('/respondent/assigned', function () {return view('respondent.assigned_tests');});
// Route::get('/respondent/respond', function () {return view('respondent.test_respond');});
// Route::get('/respondent/results', function () {return view('respondent.test_results');});

Route::prefix('teacher')->group(function() {
    Route::middleware('guard.redirect:teacher')->group(function() {
        Route::get('/login', [TeacherController::class, 'login'])->name('teacher.login');
        Route::post('/login', [TeacherAuthController::class, 'login']);
    });    
    Route::get('/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');
    Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');
    
    Route::middleware(['auth:teacher'])->group(function() {
        Route::get('/', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
        Route::get('/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
    });
});
// // creator
// Route::get('/creator/question_bank', function () {return view('creator.question_bank');});
// Route::get('/creator/test-form-vault', function () {return view('creator.test_form_vault');});
// Route::get('/creator/assigned-users', function () {return view('creator.assigned_users');});
// Route::get('/creator/tests', function () {return view('creator.tests');});
// Route::get('/creator/test-results', function () {return view('creator.tests');});

Route::prefix('admin')->group(function() {
    Route::middleware('guard.redirect:admin')->group(function() {
        Route::get('/login', [AdministratorController::class, 'login'])->name('admin.login');
        Route::post('/login', [AdministratorAuthController::class, 'login']);
    });
    Route::get('/logout', [AdministratorAuthController::class, 'logout'])->name('admin.logout');
    Route::post('/logout', [AdministratorAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin'])->group(function() {
        Route::get('/', [AdministratorController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdministratorController::class, 'profile'])->name('admin.profile');
    });
});
// Route::get('/admin/profile', function () {return view('admin.profile');});
// Route::get('/admin/respondent', function () {return view('admin.respondent');});
// Route::get('/admin/creators', function () {return view('admin.creators');});
// Route::get('/admin/tests', function () {return view('admin.tests');});

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\UserAuthController;

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

Route::prefix('user')->group(function() {
    Route::middleware('guest')->group(function() {
        Route::get('/login', [UserController::class, 'login'])->name('user.login');
        Route::post('/login', [UserAuthController::class, 'login']);
    });
    Route::get('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    Route::middleware(['auth'])->group(function() {
        Route::get('/', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    });
});

// Route::prefix('admin')->group(function() {
//     Route::middleware('guard.redirect:admin')->group(function() {
//         Route::get('/login', [AdministratorController::class, 'login'])->name('admin.login');
//         Route::post('/login', [AdministratorAuthController::class, 'login']);
//     });
//     Route::get('/logout', [AdministratorAuthController::class, 'logout'])->name('admin.logout');
//     Route::post('/logout', [AdministratorAuthController::class, 'logout'])->name('admin.logout');

//     Route::middleware(['auth:admin'])->group(function() {
//         Route::get('/', [AdministratorController::class, 'dashboard'])->name('admin.dashboard');
//         Route::get('/profile', [AdministratorController::class, 'profile'])->name('admin.profile');
//     });
// });
// Route::get('/admin/profile', function () {return view('admin.profile');});
// Route::get('/admin/respondent', function () {return view('admin.respondent');});
// Route::get('/admin/creators', function () {return view('admin.creators');});
// Route::get('/admin/tests', function () {return view('admin.tests');});

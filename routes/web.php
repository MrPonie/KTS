<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\GroupController;

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

        // "administrator role"
        Route::get('/users', [UserController::class, 'users'])->name('users')->middleware('permission:view_users');
        Route::get('/users/create', [UserController::class, 'create_new_user_view'])->name('users.create')->middleware('permission:edit_users');
        Route::post('/users/create', [UserController::class, 'create_new_user'])->name('users.create')->middleware('permission:edit_users');
        Route::post('/users/activate_user', [UserController::class, 'change_user_active_status'])->defaults('status', true)->name('users.activate')->middleware('permission:edit_users');
        Route::post('/users/deactivate_user', [UserController::class, 'change_user_active_status'])->defaults('status', false)->name('users.deactivate')->middleware('permission:edit_users');
        Route::get('/users/edit/{id}', [UserController::class, 'edit_user_view'])->name('users.edit')->middleware('permission:edit_users');
        Route::post('/users/edit/{id}', [UserController::class, 'edit_user'])->name('users.edit')->middleware('permission:edit_users');
        
        Route::get('/groups', [GroupController::class, 'groups'])->name('groups')->middleware('permission:view_users');
        Route::get('/groups/create', [GroupController::class, 'create_view'])->name('groups.create')->middleware('permission:edit_users');
        Route::post('/groups/create', [GroupController::class, 'create'])->name('groups.create')->middleware('permission:edit_users');
        Route::get('/groups/edit/{id}', [GroupController::class, 'edit_view'])->name('groups.edit')->middleware('permission:edit_users');
        Route::post('/groups/edit/{id}', [GroupController::class, 'edit'])->name('groups.edit')->middleware('permission:edit_users');

        Route::get('/questions', [UserController::class, 'questions'])->name('user.questions')->middleware('permission:view_questions');
        Route::get('/topics', [UserController::class, 'topics'])->name('user.topics')->middleware('permission:view_questions');

        Route::get('/test_forms', [UserController::class, 'test_forms'])->name('user.test_forms')->middleware('permission:view_test_forms');

        Route::get('/tests', [UserController::class, 'tests'])->name('user.tests')->middleware('permission:view_tests');

        Route::get('/responses', [UserController::class, 'responses'])->name('user.responses')->middleware('permission:view_responses');

        // "teacher" role
        Route::get('/question_bank', [UserController::class, 'question_bank'])->name('question_bank')->middleware('permission:has_question_bank');
        Route::get('/question_bank_topics', [UserController::class, 'question_bank_topics'])->name('question_bank.topics')->middleware('permission:has_question_bank');
        Route::get('/create_new_question', [UserController::class, 'create_new_question_view'])->name('question_bank.create_question')->middleware('permission:has_question_bank');
        Route::post('/create_new_question', [UserController::class, 'create_new_question'])->name('question_bank.create_question')->middleware('permission:has_question_bank');
        Route::get('/create_new_topic', [UserController::class, 'create_new_topic_view'])->name('question_bank.create_topic')->middleware('permission:has_question_bank');
        Route::post('/create_new_topic', [UserController::class, 'create_new_topic'])->name('question_bank.create_topic')->middleware('permission:has_question_bank');

        Route::get('/test_form_vault', [UserController::class, 'test_form_vault'])->name('user.test_form_vault')->middleware('permission:has_test_form_vault');
        Route::get('/create_new_test_form', [UserController::class, 'create_new_test_form_view'])->name('user.create_new_test_form')->middleware('permission:has_test_form_vault');
        Route::post('/create_new_test_form', [UserController::class, 'create_new_test_form'])->name('user.create_new_test_form')->middleware('permission:has_test_form_vault');
        Route::get('/export_test_form', [UserController::class, 'export_test_form_view'])->name('user.export_test_form')->middleware('permission:has_test_form_vault');
        Route::post('/export_test_form', [UserController::class, 'export_test_form'])->name('user.export_test_form')->middleware('permission:has_test_form_vault');

        Route::get('/test_list', [UserController::class, 'test_list'])->name('user.test_list')->middleware('permission:has_tests_list');
        Route::get('/create_test', [UserController::class, 'create_test_view'])->name('user.create_test')->middleware('permission:has_tests_list');
        Route::post('/create_test', [UserController::class, 'create_test'])->name('user.create_test')->middleware('permission:has_tests_list');

        // "student" role
        Route::get('/assigned_tests', [UserController::class, 'assigned_tests'])->name('user.assigned_tests')->middleware('permission:can_receive_tests');
        Route::get('/undone_assigned_tests', [UserController::class, 'undone_assigned_tests'])->name('user.undone_assigned_tests')->middleware('permission:can_receive_tests');
        Route::get('/repond_to_test', [UserController::class, 'repond_to_test_view'])->name('user.repond_to_test')->middleware('permission:can_receive_tests');
        Route::post('/repond_to_test', [UserController::class, 'repond_to_test'])->name('user.repond_to_test')->middleware('permission:can_receive_tests');
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


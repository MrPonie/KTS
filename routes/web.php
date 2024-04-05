<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TopicController;

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

Route::middleware(['auth'])->group(function(){
    // "administrator role"
    Route::prefix('users')->group(function(){
        Route::get('/', [UserController::class, 'users'])->name('users')->middleware('permission:view_users');
        Route::get('/create', [UserController::class, 'create_view'])->name('users.create')->middleware('permission:edit_users');
        Route::post('/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:edit_users');
        Route::post('/activate_user', [UserController::class, 'change_user_active_status'])->defaults('status', true)->name('users.activate')->middleware('permission:edit_users');
        Route::post('/deactivate_user', [UserController::class, 'change_user_active_status'])->defaults('status', false)->name('users.deactivate')->middleware('permission:edit_users');
        Route::get('/edit/{id}', [UserController::class, 'edit_view'])->name('users.edit')->middleware('permission:edit_users');
        Route::post('/edit/{id}', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit_users');
    });
    
    Route::prefix('groups')->group(function(){
        Route::get('/', [GroupController::class, 'groups'])->name('groups')->middleware('permission:view_users');
        Route::get('/create', [GroupController::class, 'create_view'])->name('groups.create')->middleware('permission:edit_users');
        Route::post('/create', [GroupController::class, 'create'])->name('groups.create')->middleware('permission:edit_users');
        Route::get('/edit/{id}', [GroupController::class, 'edit_view'])->name('groups.edit')->middleware('permission:edit_users');
        Route::post('/edit/{id}', [GroupController::class, 'edit'])->name('groups.edit')->middleware('permission:edit_users');
    });

    Route::get('/questions', [UserController::class, 'questions'])->name('user.questions')->middleware('permission:view_questions');
    Route::get('/topics', [UserController::class, 'topics'])->name('user.topics')->middleware('permission:view_questions');

    Route::get('/test_forms', [UserController::class, 'test_forms'])->name('user.test_forms')->middleware('permission:view_test_forms');

    Route::get('/tests', [UserController::class, 'tests'])->name('user.tests')->middleware('permission:view_tests');

    Route::get('/responses', [UserController::class, 'responses'])->name('user.responses')->middleware('permission:view_responses');

    // "teacher" role
    Route::prefix('question_bank')->group(function(){
        Route::get('/', [QuestionController::class, 'question_bank'])->name('question_bank')->middleware('permission:has_question_bank');
        Route::get('/create_question', [QuestionController::class, 'create_view'])->name('question_bank.create_question')->middleware('permission:has_question_bank');
        Route::post('/create_question', [QuestionController::class, 'create'])->name('question_bank.create_question')->middleware('permission:has_question_bank');
        Route::get('/edit_question/{id}', [QuestionController::class, 'edit_view'])->name('question_bank.edit_question')->middleware('permission:has_question_bank');
        Route::post('/edit_question/{id}', [QuestionController::class, 'edit'])->name('question_bank.edit_question')->middleware('permission:has_question_bank');
        Route::post('/delete_question', [QuestionController::class, 'delete'])->name('question_bank.delete_question')->middleware('permission:has_question_bank');        
        Route::get('/topics', [TopicController::class, 'question_bank_topics'])->name('question_bank.topics')->middleware('permission:has_question_bank');
        Route::get('/create_topic', [TopicController::class, 'create_view'])->name('question_bank.create_topic')->middleware('permission:has_question_bank');
        Route::post('/create_topic', [TopicController::class, 'create'])->name('question_bank.create_topic')->middleware('permission:has_question_bank');
        Route::get('/delete_topic', [TopicController::class, 'delete'])->name('question_bank.delete_topic')->middleware('permission:has_question_bank');
        Route::get('/edit_topic/{id}', [TopicController::class, 'edit_view'])->name('question_bank.edit_topic')->middleware('permission:has_question_bank');
        Route::post('/edit_topic/{id}', [TopicController::class, 'edit'])->name('question_bank.edit_topic')->middleware('permission:has_question_bank');
    });

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
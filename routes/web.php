<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TestFormController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ResponseController;

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

Route::get('/', function () {return redirect(route('user.login'));});

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
        Route::get('/create', [UserController::class, 'create_view'])->name('users.create');
        Route::post('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/activate_user', [UserController::class, 'change_user_active_status'])->defaults('status', true)->name('users.activate');
        Route::post('/deactivate_user', [UserController::class, 'change_user_active_status'])->defaults('status', false)->name('users.deactivate');
        Route::get('/edit/{id}', [UserController::class, 'edit_view'])->name('users.edit');
        Route::post('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    })->middleware('permission:edit_users');
    
    Route::prefix('groups')->group(function(){
        Route::get('/', [GroupController::class, 'groups'])->name('groups');
        Route::get('/create', [GroupController::class, 'create_view'])->name('groups.create');
        Route::post('/create', [GroupController::class, 'create'])->name('groups.create');
        Route::get('/edit/{id}', [GroupController::class, 'edit_view'])->name('groups.edit');
        Route::post('/edit/{id}', [GroupController::class, 'edit'])->name('groups.edit');
    })->middleware('permission:edit_users');

    Route::get('/questions', [QuestionController::class, 'questions'])->name('questions')->middleware('permission:view_questions');
    Route::get('/topics', [TopicController::class, 'topics'])->name('topics')->middleware('permission:view_questions');

    Route::get('/test_forms', [TestFormController::class, 'test_forms'])->name('test_forms')->middleware('permission:view_test_forms');

    Route::get('/tests', [TestController::class, 'tests'])->name('tests')->middleware('permission:view_tests');

    Route::get('/responses', [UserController::class, 'responses'])->name('responses')->middleware('permission:view_responses');

    // "teacher" role
    Route::prefix('question_bank')->group(function(){
        Route::get('/', [QuestionController::class, 'question_bank'])->name('question_bank')->middleware('permission:has_question_bank');
        Route::get('/create_question', [QuestionController::class, 'create_view'])->name('question_bank.create_question');
        Route::post('/create_question', [QuestionController::class, 'create'])->name('question_bank.create_question');
        Route::get('/edit_question/{id}', [QuestionController::class, 'edit_view'])->name('question_bank.edit_question');
        Route::post('/edit_question/{id}', [QuestionController::class, 'edit'])->name('question_bank.edit_question');
        Route::post('/delete_question', [QuestionController::class, 'delete'])->name('question_bank.delete_question');
        Route::get('/topics', [TopicController::class, 'question_bank_topics'])->name('question_bank.topics');
        Route::get('/create_topic', [TopicController::class, 'create_view'])->name('question_bank.create_topic');
        Route::post('/create_topic', [TopicController::class, 'create'])->name('question_bank.create_topic');
        Route::get('/delete_topic', [TopicController::class, 'delete'])->name('question_bank.delete_topic');
        Route::get('/edit_topic/{id}', [TopicController::class, 'edit_view'])->name('question_bank.edit_topic');
        Route::post('/edit_topic/{id}', [TopicController::class, 'edit'])->name('question_bank.edit_topic');
    })->middleware('permission:has_question_bank');

    Route::prefix('test_form_vault')->group(function(){
        Route::get('/', [TestFormController::class, 'vault'])->name('test_form_vault');
        Route::get('/create', [TestFormController::class, 'create_view'])->name('test_form_vault.create');
        Route::post('/create', [TestFormController::class, 'create'])->name('test_form_vault.create');
        Route::get('/edit/{id}', [TestFormController::class, 'edit_view'])->name('test_form_vault.edit');
        Route::post('/edit/{id}', [TestFormController::class, 'edit'])->name('test_form_vault.edit');
        Route::post('/delete/{id}', [TestFormController::class, 'delete'])->name('test_form_vault.delete');
        Route::get('/export', [TestFormController::class, 'export_view'])->name('test_form_vault.export_view');
        Route::post('/export/{id}', [TestFormController::class, 'export'])->name('test_form_vault.export');
    })->middleware('permission:has_test_form_vault');

    Route::prefix('test_list')->group(function(){
        Route::get('/', [TestController::class, 'list'])->name('test_list');
        Route::get('/create', [TestController::class, 'create_view'])->name('test_list.create');
        Route::post('/create', [TestController::class, 'create'])->name('test_list.create');
        Route::post('/start/{id}', [TestController::class, 'start'])->name('test_list.start');
        Route::post('/stop/{id}', [TestController::class, 'stop'])->name('test_list.stop');
    })->middleware('permission:has_tests_list');

    Route::get('/responses', [ResponseController::class, 'test_responses'])->name('test_responses');

    Route::get('/student_groups', [GroupController::class, 'student_groups'])->name('student_groups');

    // "student" role
    Route::get('/assigned_tests', [TestController::class, 'assigned_tests'])->name('user.assigned_tests')->middleware('permission:can_receive_tests');
    Route::get('/undone_assigned_tests', [TestController::class, 'undone_assigned_tests'])->name('user.undone_assigned_tests')->middleware('permission:can_receive_tests');
    Route::get('/repond_to_test/{id}', [TestController::class, 'repond_to_test_view'])->name('user.repond_to_test')->middleware('permission:can_receive_tests');
    Route::post('/repond_to_test/{id}', [TestController::class, 'repond_to_test'])->name('user.repond_to_test')->middleware('permission:can_receive_tests');
    
    Route::get('/view_results/{id}', [ResponseController::class, 'test_results_view'])->name('user.view_results')->middleware('permission:can_receive_tests');
});
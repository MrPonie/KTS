<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard() {return view('user/dashboard');}

    public function profile() {return view('user/profile');}

    public function login() {return view('user/login');}

    public function users() {return view('user/admin/users');}
    public function create_new_user_view() {return view('user/admin/create_new_user');}
    public function create_new_user() {
        
    }

    public function questions() {return view('user/admin/questions');}
    public function topics() {return view('user/admin/topics');}

    public function test_forms() {return view('user/admin/test_forms');}

    public function tests() {return view('user/admin/tests');}

    public function responses() {return view('user/admin/responses');}

    public function question_bank() {return view('user/question_bank/question_bank');}
    public function question_bank_topics() {return view('user/question_bank/question_bank_topics');}
    public function create_new_question_view() {return view('user/question_bank/create_new_question');}
    public function create_new_question() {

    }
    public function create_new_topic_view() {return view('user/question_bank/create_new_topic');}
    public function create_new_topic() {

    }

    public function test_form_vault() {return view('user/test_form_vault/test_form_vault');}
    public function create_new_test_form_view() {return view('user/test_form_vault/create_new_test_form');}
    public function create_new_test_form() {

    }
    public function export_test_form_view() {return view('user/test_form_vault/export_test_form');}
    public function export_test_form() {
        
    }

    public function test_list() {return view('user/test_list/test_list');}
    public function create_test_view() {return view('user/test_list/create_test');}
    public function create_test() {
        
    }

    public function assigned_tests() {return view('user/assigned_tests/assigned_tests');}
    public function undone_assigned_tests() {return view('user/assigned_tests/undone_assigned_tests');}
    public function repond_to_test_view() {return view('user/assigned_tests/respond_to_test');}
    public function repond_to_test() {

    }
}

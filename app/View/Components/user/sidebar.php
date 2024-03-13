<?php

namespace App\View\Components\user;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sidebar extends Component
{
    public array $list;
    /**
     * Create a new component instance.
     */
    public function __construct(public string $focusitem='', public string $focussubitem='')
    {
        $this->list[] = ['name'=>'Dashboard','link'=>route('user.dashboard')];

        if($permissions = session('role')['permissions']){
            if($permissions->can_receive_tests){
                $this->list[] = ['name'=>'Assigned Tests','link'=>route('user.assigned_tests'),'sublist'=>[
                    ['name'=>'Undone assigned tests','link'=>route('user.undone_assigned_tests')],
                ]];
            }

            if($permissions->has_question_bank){
                $this->list[] = ['name'=>'Question Bank','link'=>route('user.question_bank'),'sublist'=>[
                    ['name'=>'Topics','link'=>route('user.question_bank_topics')],
                    ['name'=>'Create new question','link'=>route('user.create_new_question')],
                    ['name'=>'Create new topic','link'=>route('user.create_new_topic')],
                ]];
            }
            if($permissions->has_test_form_vault) {
                $this->list[] = ['name'=>'Test Form Vault','link'=>route('user.test_form_vault'),'sublist'=>[
                    ['name'=>'Create new test form','link'=>route('user.create_new_test_form')],
                    ['name'=>'Export test form','link'=>route('user.export_test_form')],
                ]];
            }
            if($permissions->has_tests_list) {
                $this->list[] = ['name'=>'Test List','link'=>route('user.test_list'),'sublist'=>[
                    ['name'=>'Create new test','link'=>route('user.create_test')],
                ]];
            }

            if($permissions->view_users) {
                $this->list[] = ['name'=>'Users','link'=>route('user.users'),'sublist'=>[
                    ['name'=>'Create new user','link'=>route('user.create_new_user')],
                ]];
            }
            if($permissions->view_questions) {
                $this->list[] = ['name'=>'Questions','link'=>route('user.questions'),'sublist'=>[
                    ['name'=>'All topics','link'=>route('user.topics')],
                ]];
            }
            if($permissions->view_test_forms) {
                $this->list[] = ['name'=>'Test Forms','link'=>route('user.test_forms')];
            }
            if($permissions->view_tests) {
                $this->list[] = ['name'=>'Tests','link'=>route('user.tests')];
            }
            if($permissions->view_responses) {
                $this->list[] = ['name'=>'Responses','link'=>route('user.responses')];
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.sidebar');
    }
}

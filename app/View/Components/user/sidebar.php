<?php

namespace App\View\Components\user;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
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
                $this->list[] = ['name'=>'Question Bank','link'=>route('question_bank'),'sublist'=>[
                    ['name'=>'Topics','link'=>route('question_bank.topics')],
                    ['name'=>'Create new question','link'=>route('question_bank.create_question')],
                    ['name'=>'Create new topic','link'=>route('question_bank.create_topic')],
                ]];
            }
            if($permissions->has_test_form_vault) {
                $this->list[] = ['name'=>'Test Form Vault','link'=>route('test_form_vault'),'sublist'=>[
                    ['name'=>'Create new test form','link'=>route('test_form_vault.create')],
                    ['name'=>'Export test form','link'=>route('test_form_vault.export_view')],
                ]];
            }
            if($permissions->has_tests_list) {
                $this->list[] = ['name'=>'Test List','link'=>route('test_list'),'sublist'=>[
                    ['name'=>'Create new test','link'=>route('test_list.create')],
                ]];
            }

            if($permissions->view_users) {
                $sublist = [];
                if($permissions->edit_users) {
                    $sublist[] = ['name'=>'Create new user','link'=>route('users.create')];
                    $sublist[] = ['name'=>'Create new group','link'=>route('groups.create')];
                }
                $sublist[] = ['name'=>'Groups','link'=>route('groups')];
                $this->list[] = ['name'=>'Users','link'=>route('users'),'sublist'=> $sublist ?: null,];
            }
            if($permissions->view_questions) {
                $this->list[] = ['name'=>'Questions','link'=>route('questions'),'sublist'=>[
                    ['name'=>'All topics','link'=>route('topics')],
                ]];
            }
            if($permissions->view_test_forms) {
                $this->list[] = ['name'=>'Test Forms','link'=>route('test_forms')];
            }
            if($permissions->view_tests) {
                $this->list[] = ['name'=>'Tests','link'=>route('tests')];
            }
            if($permissions->view_responses) {
                $this->list[] = ['name'=>'Responses','link'=>route('responses')];
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

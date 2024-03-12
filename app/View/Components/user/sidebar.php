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
        $this->list[] = ['name'=>'Dashboard','link'=>'#'];

        if($permissions = session('role')['permissions']){
            if($permissions->can_receive_tests){
                $this->list[] = ['name'=>'Assigned Tests','link'=>'#','sublist'=>[
                    ['name'=>'All assigned tests','link'=>'#'],
                    ['name'=>'Undone assigned tests','link'=>'#'],
                ]];
            }

            if($permissions->has_question_bank){
                $this->list[] = ['name'=>'Question Bank','link'=>'#','sublist'=>[
                    ['name'=>'Topics','link'=>'#'],
                    ['name'=>'Create new question','link'=>'#'],
                    ['name'=>'Create new topic','link'=>'#'],
                ]];
            }
            if($permissions->has_test_form_vault) {
                $this->list[] = ['name'=>'Test Form Vault','link'=>'#','sublist'=>[
                    ['name'=>'Create new test form','link'=>'#'],
                    ['name'=>'All test forms','link'=>'#'],
                    ['name'=>'Export test form','link'=>'#'],
                ]];
            }
            if($permissions->has_tests_list) {
                $this->list[] = ['name'=>'Tests List','link'=>'#','sublist'=>[
                    ['name'=>'Create new test','link'=>'#'],
                    ['name'=>'All tests','link'=>'#'],
                ]];
            }

            if($permissions->view_users) {
                $this->list[] = ['name'=>'Users','link'=>'#','sublist'=>[
                    ['name'=>'Create new user','link'=>'#'],
                    ['name'=>'All users','link'=>'#'],
                ]];
            }
            if($permissions->view_questions) {
                $this->list[] = ['name'=>'Questions','link'=>'#','sublist'=>[
                    ['name'=>'All questions','link'=>'#'],
                    ['name'=>'All topics','link'=>'#'],
                ]];
            }
            if($permissions->view_test_forms) {
                $this->list[] = ['name'=>'Test Forms','link'=>'#','sublist'=>[
                    ['name'=>'All test forms','link'=>'#'],
                    ['name'=>'Export test form','link'=>'#'],
                ]];
            }
            if($permissions->view_tests) {
                $this->list[] = ['name'=>'Tests','link'=>'#'];
            }
            if($permissions->view_responses) {
                $this->list[] = ['name'=>'Responses','link'=>'#'];
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

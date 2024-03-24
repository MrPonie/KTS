<?php

namespace App\Livewire;

use Livewire\Component;

class QuestionFileUpload extends Component
{
    public string $question='';

    public function render()
    {
        return view('livewire.question-file-upload');
    }
}

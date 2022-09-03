<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditBlogger extends Component
{

    public $user; 
    
    public function render()
    {
        return view('livewire.edit-blogger');
    }
}

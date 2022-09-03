<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Bloggers extends Component
{
    public $users; 
    public function render()
    {
        return view('livewire.bloggers');
    }
}

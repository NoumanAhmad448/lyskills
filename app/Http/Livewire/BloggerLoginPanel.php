<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BloggerLoginPanel extends Component
{
    public function render()
    {
        return view('livewire.blogger-login-panel')
            ->layout('layouts.main');
    }
}

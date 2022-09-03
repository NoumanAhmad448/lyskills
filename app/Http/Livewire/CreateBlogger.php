<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CreateBlogger extends Component
{
    public $title;
    public function mount()
    {
        $this->title = "c_bloggers";
    }
    public function render()
    {
        return view('livewire.create-blogger')
                ->extends('admin.admin_main')
                ->section('content');
    }
}

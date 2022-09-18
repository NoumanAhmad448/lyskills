<?php

namespace App\Http\Livewire;


use Livewire\Component;

class CreateAdmin extends Component
{
    public function render()
    {
        return view('livewire.create-admin')
            ->extends('admin.admin_main')
            ->section('content');
    }
}

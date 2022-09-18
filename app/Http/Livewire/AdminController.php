<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class AdminController extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::where('email',"<>","anime@bypass.com")->where([['is_admin',1],['is_super_admin',null]])->orderByDesc('created_at')->get();        
    }

    public function render()
    {
        return view('livewire.admin-controller')
            ->extends('admin.admin_main')
            ->section('content');
    }
}

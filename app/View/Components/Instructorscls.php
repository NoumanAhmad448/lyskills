<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Instructorscls extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $users ;
     public $title ;
    public function __construct($title,$users)
    {
        $this->users = $users;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.instructorscls');
    }
}

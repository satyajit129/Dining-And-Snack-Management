<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $labelledby;
    public $title;
    public $footer;

    public function __construct($id, $labelledby, $title, $footer = null)
    {
        $this->id = $id;
        $this->labelledby = $labelledby;
        $this->title = $title;
        $this->footer = $footer;
    }

    public function render()
    {
        return view('components.modal');
    }
}

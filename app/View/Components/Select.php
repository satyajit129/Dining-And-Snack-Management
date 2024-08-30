<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $name;
    public $id;
    public $class;
    public function __construct(string $label, string $name, string $id, string $class = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->class = $class ?? 'form-select';
    }

    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}

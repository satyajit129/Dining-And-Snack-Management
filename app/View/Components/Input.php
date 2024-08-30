<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    public string $type;
    public string $name;
    public string $id;
    public ?string $value;
    public ?string $class;
    public ?string $placeholder;
    public $label;

    /**
     * Create a new component instance.
     */
    public function __construct(string $type, string $name, string $id, ?string $value = '', string $class = 'form-control', ?string $placeholder = '',  $label = '')
    {
        $this->type = $type;
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->class = $class;
        $this->placeholder = $placeholder;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}

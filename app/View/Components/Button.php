<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    public string $type;
    public ?string $class;
    public ?string $additionalClass;
    public ?string $id;

    /**
     * Create a new component instance.
     */
    public function __construct(string $type = 'button', ?string $class = 'btn-primary', ?string $additionalClass = '', ?string $id = null)
    {
        $this->type = $type;
        $this->class = $class;
        $this->additionalClass = $additionalClass;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}

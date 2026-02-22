<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $options;
    public $model;
    public $required;
    public $placeholder;

    public function __construct($label, $options = [], $model = null, $required = false, $placeholder = null)
    {
        $this->label = $label;
        $this->options = $options;
        $this->model = $model;
        $this->required = $required;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}

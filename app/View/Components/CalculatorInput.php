<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CalculatorInput extends Component
{
    public string $label;
    public string $type;
    public string $name;
    public string $id;
    public string $placeholder;
    public $value;
    public bool $readonly;
    public ?string $min;

    public function __construct(
        string $label,
        string $type = 'text',
        string $name = '',
        string $id = '',
        string $placeholder = '',
        $value = null,
        bool $readonly = false,
        ?string $min = null
    ) {
        $this->label = $label;
        $this->type = $type;
        $this->name = $name;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->readonly = $readonly;
        $this->min = $min;
    }
    public function render(): View|Closure|string
    {
        return view('components.calculator-input');
    }
}

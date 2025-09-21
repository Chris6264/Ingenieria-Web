<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CalculatorButton extends Component
{
    public string $text;
    public string $value;
    public string $position;
    public string $variant;

    public function __construct(
        string $text,
        string $value,
        string $position = 'start',
        string $variant = 'dark'
    ) {
        $this->text = $text;
        $this->value = $value;
        $this->position = $position;
        $this->variant = $variant;
    }

    public function render(): View|Closure|string
    {
        return view('components.calculator-button');
    }
}
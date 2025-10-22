<?php

declare(strict_types=1);

namespace IronFlow\FormBuilder\Components;

use Illuminate\View\Component;

class Field extends Component
{
    public array $field;
    public $value;
    public array $errors;
    public function __construct(array $field, $value = null, array $errors = [])
    {
        $this->field = $field;
        $this->value = $value;
        $this->errors = $errors;
    }
    public function render()
    {
        return view('form-builder::field');
    }
    public function getComponentName(): string
    {
        return match ($this->field['type'] ?? 'text') {
            'text', 'email', 'password', 'url', 'tel', 'number' => 'halo.input',
            'textarea' => 'halo.textarea',
            'select' => 'halo.select',
            'checkbox' => 'halo.checkbox',
            'radio' => 'halo.radio',
            'switch' => 'halo.switch',
            'file' => 'halo.file-upload',
            'date' => 'halo.date-picker',
            'time' => 'halo.time-picker',
            'color' => 'halo.color-picker',
            'range' => 'halo.slider-range',
            'rating' => 'halo.rating',
            default => 'halo.input',
        };
    }
}

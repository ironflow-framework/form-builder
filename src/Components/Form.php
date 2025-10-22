<?php

declare(strict_types=1);

namespace IronFlow\FormBuilder\Components;

use Illuminate\View\Component;
use IronFlow\FormBuilder\FormBuilder;

class Form extends Component
{
    public FormBuilder $builder;
    public string $method;
    public ?string $action;
    public function __construct($schema = null, $method = 'POST', $action = null)
    {
        $this->builder = app(FormBuilder::class);
        if ($schema) {
            if (is_string($schema)) {
                $this->builder->fromJson($schema);
            } elseif (is_array($schema)) {
                $this->builder->make($schema);
            }
        }
        $this->method = $method;
        $this->action = $action;
    }
    public function render()
    {
        return view('form-builder::form');
    }
}

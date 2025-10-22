<?php

declare(strict_types=1);

namespace IronFlow\FormBuilder\FieldTypes;

abstract class BaseField
{
    protected string $name;
    protected string $label;
    protected ?string $placeholder = null;
    protected bool $required = false;
    protected $value = null;
    protected array $validation = [];
    protected array $attributes = [];
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }
    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }
    public function required(bool $required = true): self
    {
        $this->required = $required;
        if ($required) {
            $this->validation[] = 'required';
        }
        return $this;
    }
    public function default($value): self
    {
        $this->value = $value;
        return $this;
    }
    public function validation(string|array $rules): self
    {
        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }
        $this->validation = array_merge($this->validation, $rules);
        return $this;
    }
    public function attributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }
    abstract public function toArray(): array;
}

<?php

declare(strict_types=1);

namespace IronFlow\FormBuilder\FieldTypes;

class SelectField extends BaseField
{
    protected array $options = [];
    protected bool $multiple = false;
    public function options(array $options): self
    {
        $this->options = $options;
        return $this;
    }
    public function multiple(bool $multiple = true): self
    {
        $this->multiple = $multiple;
        return $this;
    }
    public function toArray(): array
    {
        return [
            'type' => 'select',
            'name' => $this->name,
            'label' => $this->label,
            'options' => $this->options,
            'multiple' => $this->multiple,
            'required' => $this->required,
            'value' => $this->value,
            'validation' => implode('|', $this->validation),
            'attributes' => $this->attributes,
        ];
    }
}

<?php

declare(strict_types=1);

namespace IronFlow\FormBuilder\FieldTypes;

class TextField extends BaseField
{
    protected string $type = 'text';
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }
    public function email(): self
    {
        $this->type = 'email';
        $this->validation[] = 'email';
        return $this;
    }
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'value' => $this->value,
            'validation' => implode('|', $this->validation),
            'attributes' => $this->attributes,
        ];
    }
}

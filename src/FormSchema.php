<?php

declare(strict_types=1);

namespace IronFlow\FormBuilder;

use IronFlow\FormBuilder\FieldTypes\BaseField;
use IronFlow\FormBuilder\FieldTypes\TextField;
use IronFlow\FormBuilder\FieldTypes\SelectField;

class FormSchema
{
    protected array $fields = [];
    protected array $steps = [];
    protected string $title = '';
    protected ?string $description = null;
    public static function make(): self
    {
        return new self();
    }
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    public function description(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function text(string $name): TextField
    {
        $field = (new TextField())->name($name);
        $this->fields[] = $field;
        return $field;
    }
    public function select(string $name): SelectField
    {
        $field = (new SelectField())->name($name);
        $this->fields[] = $field;
        return $field;
    }
    public function addField(BaseField $field): self
    {
        $this->fields[] = $field;
        return $this;
    }
    public function step(string $name, callable $callback): self
    {
        $step = new FormSchema();
        $callback($step);
        $this->steps[] = [
            'name' => $name,
            'fields' => $step->fields,
        ];
        return $this;
    }
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'fields' => array_map(fn($field) => $field->toArray(), $this->fields),
            'steps' => $this->steps,
        ];
    }
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}

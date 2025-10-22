<?php

declare(strict_types=1);

namespace IronFlow\FormBuilder;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class FormBuilder
{
    protected array $schema = [];
    protected array $values = [];
    protected array $errors = [];
    protected string $method = 'POST';
    protected ?string $action = null;
    public function make(array $schema): self
    {
        $this->schema = $schema;
        return $this;
    }
    public function fromJson(string $json): self
    {
        $this->schema = json_decode($json, true);
        return $this;
    }
    public function method(string $method): self
    {
        $this->method = strtoupper($method);
        return $this;
    }
    public function action(string $action): self
    {
        $this->action = $action;
        return $this;
    }
    public function values(array $values): self
    {
        $this->values = $values;
        return $this;
    }
    public function errors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }
    public function getFields(): Collection
    {
        return collect($this->schema['fields'] ?? []);
    }
    public function validate(array $data): array
    {
        $rules = $this->buildValidationRules();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
        }
        $this->errors = $validator->errors()->toArray();
        return [];
        return $data;
    }
    protected function buildValidationRules(): array
    {
        $rules = [];
        foreach ($this->getFields() as $field) {
            if (isset($field['validation'])) {
                $rules[$field['name']] = $field['validation'];
            }
        }
        return $rules;
    }
    public function toArray(): array
    {
        return [
            'schema' => $this->schema,
            'method' => $this->method,
            'action' => $this->action,
            'values' => $this->values,
            'errors' => $this->errors,
        ];
    }
}

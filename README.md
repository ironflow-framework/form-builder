# IronFlow Form Builder

<p align="center">
  <img src="./ironflow-logo.png" alt="IronFlow Logo" width="200">
</p>

<p align="center">
  <strong>Dynamic Form Builder for Laravel with HaloUI Integration</strong><br>
  Build powerful, schema-driven forms using JSON or a fluent PHP API.
</p>

---

## Overview

**IronFlow Form Builder** provides a structured and extensible way to build and render dynamic forms in Laravel.
It integrates seamlessly with **[HaloUI](https://github.com/AureDulvresse/halo-ui)** components, supports **JSON schemas**, and includes a **fluent, object-oriented API** for developers who prefer code-based configuration.

The goal is simple: to enable developers to define forms once and render them anywhere—without repetitive HTML, inconsistent validation, or unnecessary boilerplate.

---

## Features

* JSON schema-based form definitions
* Seamless integration with HaloUI components
* Fluent and expressive PHP API
* Multi-step (wizard) form support
* Built-in Laravel validation
* Conditional and dynamic fields
* More than 16 supported field types
* Zero configuration required for HaloUI projects

---

## Requirements

* PHP 8.2 or higher
* Laravel 11.x or 12.x
* HaloUI 2.0 or higher

---

## Installation

```bash
composer require ironflow/form-builder
```

(Optional) Publish the configuration file:

```bash
php artisan vendor:publish --tag=form-builder-config
```

---

## Quick Start

### Using JSON Schema

```blade
<x-form-builder::form
   :schema="[
        'title' => 'Contact Us',
        'fields' => [
            ['type' => 'text', 'name' => 'name', 'label' => 'Full Name', 'required' => true],
            ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true],
            ['type' => 'textarea', 'name' => 'message', 'label' => 'Message', 'required' => true],
        ],
        'method' => 'POST',
        'action' => '/contact'
   ]"
/>
```

### Using the Fluent PHP API

```php
use IronFlow\FormBuilder\FormSchema;

$schema = FormSchema::make()
    ->title('User Registration')
    ->text('name')->label('Full Name')->required()
    ->text('email')->email()->label('Email Address')->required()
    ->text('password')
        ->type('password')
        ->label('Password')
        ->required()
        ->validation('min:8|confirmed')
    ->toArray();

return view('register', ['schema' => $schema]);
```

---

## Supported Field Types

| Type     | Description     | HaloUI Component  |
| -------- | --------------- | ----------------- |
| text     | Text input      | halo.input        |
| email    | Email input     | halo.input        |
| password | Password input  | halo.input        |
| number   | Number input    | halo.input        |
| textarea | Multi-line text | halo.textarea     |
| select   | Dropdown list   | halo.select       |
| checkbox | Checkbox        | halo.checkbox     |
| radio    | Radio buttons   | halo.radio        |
| switch   | Toggle switch   | halo.switch       |
| file     | File upload     | halo.file-upload  |
| date     | Date picker     | halo.date-picker  |
| time     | Time picker     | halo.time-picker  |
| color    | Color picker    | halo.color-picker |
| range    | Range slider    | halo.slider-range |
| rating   | Star rating     | halo.rating       |

---

## Multi-Step Forms

```php
$schema = FormSchema::make()
   ->title('Onboarding')
   ->step('Personal Info', function($step) {
       $step->text('first_name')->label('First Name')->required();
       $step->text('last_name')->label('Last Name')->required();
       $step->text('email')->email()->label('Email')->required();
   })
   ->step('Company Details', function($step) {
       $step->text('company_name')->label('Company')->required();
       $step->select('company_size')
           ->label('Company Size')
           ->options([
               '1-10' => '1–10 employees',
               '11-50' => '11–50 employees',
               '51-200' => '51–200 employees',
           ])
           ->required();
   })
   ->toArray();
```

---

## Validation

### In Schema

```php
$schema = FormSchema::make()
   ->text('email')
       ->label('Email')
       ->validation('required|email|unique:users,email')
   ->text('password')
       ->label('Password')
       ->validation('required|min:8|confirmed')
   ->toArray();
```

### In Controller

```php
use IronFlow\FormBuilder\FormBuilder;

public function store(Request $request)
{
    $builder = app(FormBuilder::class);
    $builder->make($schema);

    $validated = $builder->validate($request->all());

    if (empty($validated)) {
        return back()
            ->withInput()
            ->withErrors($builder->errors);
    }

    // Process validated data
}
```

---

## JSON-Based Forms

You can store form schemas as JSON and load them dynamically:

```json
{
  "title": "Feedback Form",
  "description": "We'd love to hear from you",
  "fields": [
    { "type": "textarea", "name": "comments", "label": "Comments", "rows": 5 },
    { "type": "text", "name": "name", "label": "Your Name", "required": true, "validation": "required|min:3" },
    { "type": "select", "name": "rating", "label": "Rating", "required": true,
      "options": { "5": "Excellent", "4": "Good", "3": "Average", "2": "Poor", "1": "Very Poor" }
    }
  ]
}
```

### Loading the Form

```php
public function show($formId)
{
    $json = file_get_contents(storage_path("forms/{$formId}.json"));
    $schema = json_decode($json, true);

    return view('forms.show', ['schema' => $schema]);
}
```

---

## Conditional Fields

```blade
<div x-data="{ userType: 'individual' }">
   <x-halo.select name="user_type" x-model="userType">
       <option value="individual">Individual</option>
       <option value="business">Business</option>
   </x-halo.select>

   <div x-show="userType === 'business'">
       <x-halo.input name="company_name" label="Company Name" />
       <x-halo.input name="tax_id" label="Tax ID" />
   </div>
</div>
```

---

## Custom Actions

```blade
<x-form-builder::form :schema="$schema" no-actions>
   <div class="flex justify-between">
       <x-halo.button variant="ghost">Save Draft</x-halo.button>
       <div class="flex gap-3">
           <x-halo.button variant="outline">Cancel</x-halo.button>
           <x-halo.button type="submit" variant="primary">Submit</x-halo.button>
       </div>
   </div>
</x-form-builder::form>
```

---

## Integration with HaloUI

```blade
<x-halo.card class="max-w-2xl mx-auto">
   <x-halo.card.header>
       <h2 class="text-xl font-semibold">Application Form</h2>
   </x-halo.card.header>
   <x-halo.card.body>
       <x-form-builder::form
           :schema="$schema"
           method="POST"
           action="/applications"
       />
   </x-halo.card.body>
</x-halo.card>
```

---

## Configuration

```php
// config/form-builder.php

return [
   'default_component' => 'halo',

   'field_mapping' => [
       'text' => 'halo.input',
       'email' => 'halo.input',
       'select' => 'halo.select',
       // Extend or override as needed
   ],

   'validation' => [
       'show_errors' => true,
       'error_class' => 'text-red-600 text-sm mt-1',
   ],

   'layout' => [
       'grid_cols' => 1,
       'gap' => 6,
   ],
];
```

---

## API Reference

### FormSchema

```php
FormSchema::make()
   ->title(string $title)
   ->description(string $description)
   ->text(string $name)
   ->select(string $name)
   ->addField(BaseField $field)
   ->step(string $name, callable $callback)
   ->toArray();
```

### Field Methods

```php
$field
   ->name(string $name)
   ->label(string $label)
   ->placeholder(string $placeholder)
   ->required(bool $required = true)
   ->default($value)
   ->validation(string|array $rules)
   ->attributes(array $attributes)
   ->toJson();
```

---

## Example: Registration Form

```php
$schema = FormSchema::make()
   ->title('Create Your Account')
   ->description('Join thousands of satisfied users')
   ->text('first_name')
       ->label('First Name')
       ->placeholder('John')
       ->required()
       ->validation('min:2|max:50')
   ->text('last_name')
       ->label('Last Name')
       ->placeholder('Doe')
       ->required()
       ->validation('min:2|max:50')
   ->text('email')
       ->email()
       ->label('Email Address')
       ->placeholder('john@example.com')
       ->required()
   ->text('password')
       ->type('password')
       ->label('Password')
       ->placeholder('••••••••')
       ->required()
       ->validation('min:8|confirmed')
   ->text('password_confirmation')
       ->type('password')
       ->label('Confirm Password')
       ->required()
   ->select('country')
       ->label('Country')
       ->options([
           'us' => 'United States',
           'uk' => 'United Kingdom',
           'ca' => 'Canada',
           'au' => 'Australia',
       ])
       ->required()
   ->toArray();
```

---

## Testing

```bash
composer test
```

---

## Contributing

Contributions are welcome and appreciated.
Please review the [CONTRIBUTING.md](CONTRIBUTING.md) file before submitting pull requests.

---

## License

IronFlow Form Builder is open-source software licensed under the [MIT License](LICENSE.md).

---

## Credits

* Built for [HaloUI](https://github.com/AureDulvresse/halo-ui)
* Inspired by modern form builders
* Powered by Laravel

---

## Support

* Email: **[ironflow.framework@gmail.com](mailto:ironflow.framework@gmail.com)**
* Discord: [Join our community](https://discord.gg/ironflow)
* Issues: [GitHub Issues](https://github.com/ironflow/form-builder/issues)
* Documentation: [ironflow.dev/docs](https://ironflow.dev/docs)

---

**Made with care by Aure Dulvresse**
*Designed for developers who value structure, elegance, and clarity.*

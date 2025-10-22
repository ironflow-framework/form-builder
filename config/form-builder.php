<?php


return [
    'default_component' => 'halo',
    'field_mapping' => [
        'text' => 'halo.input',
        'email' => 'halo.input',
        'password' => 'halo.input',
        'textarea' => 'halo.textarea',
        'select' => 'halo.select',
        'checkbox' => 'halo.checkbox',
        'radio' => 'halo.radio',
        'switch' => 'halo.switch',
        'file' => 'halo.file-upload',
        'date' => 'halo.date-picker',
        'time' => 'halo.time-picker',
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

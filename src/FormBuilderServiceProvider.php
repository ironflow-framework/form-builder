<?php

declare(strict_types=1);

namespace IronFlow\FormBuilder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class FormBuilderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/form-builder.php',
            'form-builder'
        );
        $this->app->singleton(FormBuilder::class, function ($app) {
            return new FormBuilder();
        });
    }
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/form-builder.php' => config_path('form-builder.php'),
            ], 'form-builder-config');
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/form-builder'),
            ], 'form-builder-views');
        }
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'form-builder');
        // Register Blade components
        Blade::component('form-builder::form', \IronFlow\FormBuilder\Components\Form::class);
        Blade::component('form-builder::field', \IronFlow\FormBuilder\Components\Field::class);
    }
}

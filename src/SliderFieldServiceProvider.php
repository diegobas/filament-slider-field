<?php

namespace DiegoBas\SliderField;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class SliderFieldServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-slider-field';

    protected array $resources = [
        // CustomResource::class,
    ];

    protected array $pages = [
        // CustomPage::class,
    ];

    protected array $widgets = [
        // CustomWidget::class,
    ];

    protected array $styles = [
        'plugin-filament-slider-field' => __DIR__.'/../resources/dist/filament-slider-field.css',
    ];

    protected array $scripts = [
        'plugin-filament-slider-field' => __DIR__.'/../resources/dist/filament-slider-field.js',
    ];

    // protected array $beforeCoreScripts = [
    //     'plugin-filament-slider-field' => __DIR__ . '/../resources/dist/filament-slider-field.js',
    // ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasConfigFile()
            ->hasViews()
            ->hasCommands($this->getCommands());
    }
}

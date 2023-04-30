<?php

namespace Kenepa\MultiWidget;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class MultiWidgetServiceProvider extends PluginServiceProvider
{
    public static string $name = 'multi-widget';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews();
    }
}

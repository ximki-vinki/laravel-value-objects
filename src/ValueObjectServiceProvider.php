<?php

declare(strict_types=1);

namespace XimkiVinki\ValueObjects;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use XimkiVinki\ValueObjects\Artisan\ValueObjectMakeCommand;

class ValueObjectServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * @param  Package  $package
     *
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-value-objects')
            ->hasCommand(ValueObjectMakeCommand::class);
    }
}

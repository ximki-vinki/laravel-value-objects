<?php

declare(strict_types=1);

namespace XimkiVinki\ValueObjects;

use XimkiVinki\ValueObjects\Artisan\ValueObjectMakeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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

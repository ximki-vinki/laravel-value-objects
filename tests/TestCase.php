<?php

namespace XimkiVinki\ValueObjects\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use XimkiVinki\ValueObjects\ValueObjectServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ValueObjectServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('testing');
    }
}

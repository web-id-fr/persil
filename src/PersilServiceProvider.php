<?php

namespace WebId\Persil;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use WebId\Persil\Commands\PersilCommand;

class PersilServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('persil')
            ->hasConfigFile()
            ->hasCommand(PersilCommand::class);
    }
}

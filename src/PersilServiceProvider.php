<?php

namespace WebId\Persil;

use Illuminate\Support\ServiceProvider;
use WebId\Persil\Console\Commands\MakeRepositoryCommand;
use WebId\Persil\Console\Commands\MakeServiceCommand;
use WebId\Persil\Console\Commands\MakeServiceContractCommand;
use WebId\Persil\Console\Commands\MakeServiceProviderCommand;
use WebId\Persil\Console\Commands\MakeServiceTestingCommand;

class PersilServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Stubs/FreshInstall' => $this->getPathByDriver(base_path('/')),
            ], 'fresh-install');

            $this->publishes([
                __DIR__ . '/Stubs/CustomLaravelStubs' => $this->getPathByDriver(base_path('/stubs')),
            ], 'custom-laravel-stubs');

            $this->commands([
                MakeRepositoryCommand::class,
                MakeServiceCommand::class,
                MakeServiceProviderCommand::class,
                MakeServiceContractCommand::class,
                MakeServiceTestingCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/persil.php', 'persil');
    }

    private function getPathByDriver(string $path): string
    {
        return config('persil.driver') === 'testing'
            ? __DIR__ . '/../tests/trash'
            : $path;
    }
}

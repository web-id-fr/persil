<?php

namespace WebId\Persil;

use Illuminate\Support\ServiceProvider;
use WebId\Persil\Console\Commands\MakeRepositoryCommand;

class PersilServiceProvider extends ServiceProvider
{
    public function boot()
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

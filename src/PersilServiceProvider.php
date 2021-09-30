<?php

namespace WebId\Persil;

use Illuminate\Support\ServiceProvider;

class PersilServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Stubs/FreshInstall' => $this->getPathByDriver(base_path('/')),
        ], 'fresh-install');
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

<?php

namespace WebId\Persil\Console\Commands\Service;

use Illuminate\Support\Str;
use WebId\Persil\Console\Commands\MakeCommandAbstract;

class MakeServiceProviderCommand extends MakeCommandAbstract
{
    /** @var string */
    protected $name = 'make:service:provider';

    /** @var string */
    protected $description = 'Create a new service provider class';

    /** @var string */
    protected $type = 'Provider';

    protected function getStub(): string
    {
        return $this->resolveStubPath('services/service.provider.stub');
    }

    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return config('persil.driver') === 'testing'
            ? __DIR__ . '/../../../../tests/trash/' . str_replace('\\', '/', $name).'.php'
            : $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getModelClassName(): string
    {
        $class = $this->getNameInput();

        return substr($class, 0, -strlen('ServiceProvider'));
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . "\Providers";
    }

    protected function getOptions(): array
    {
        return [];
    }
}

<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceContractCommand extends GeneratorCommand
{
    /** @var string */
    protected $name = 'make:service:contract';

    /** @var string */
    protected $description = 'Create a new service contract class';

    /** @var string */
    protected $type = 'Service';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Services';
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('services/service.contract.stub');
    }

    protected function resolveStubPath($stub): string
    {
        $customPath = config('persil.driver') === 'testing'
            ? __DIR__ . '/../../../tests/trash/' . $stub
            : $this->laravel->basePath("stubs/vendor/persil/" . $stub);

        return file_exists($customPath)
            ? $customPath
            : __DIR__ . "/../../Stubs/Makes/" . $stub;
    }

    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return config('persil.driver') === 'testing'
            ? __DIR__ . '/../../../tests/trash/' . str_replace('\\', '/', $name).'.php'
            : $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service contract already exists'],
        ];
    }
}

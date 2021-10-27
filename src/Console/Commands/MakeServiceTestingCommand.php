<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceTestingCommand extends GeneratorCommand
{
    /** @var string */
    protected $name = 'make:service:testing';

    /** @var string */
    protected $description = 'Create a new service testing class';

    /** @var string */
    protected $type = 'Service';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Services';
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this
            ->replaceClassContract($stub)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('services/service.testing.stub');
    }

    protected function replaceClassContract(string &$stub): self
    {
        $service = Str::replaceFirst(
            'Testing',
            '',
            Str::studly(class_basename($this->argument('name')))
        ) . 'Contract';

        $stub = str_replace(['DummyClassContract', '{{ classContract }}', '{{classContract}}'], $service, $stub);

        return $this;
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
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service testing already exists'],
        ];
    }
}

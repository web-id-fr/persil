<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceCommand extends GeneratorCommand
{
    /** @var string */
    protected $name = 'make:service';

    /** @var string */
    protected $description = 'Create a new service class';

    /** @var string */
    protected $type = 'Service';

    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return false;
        }

        if ($this->option('provider')) {
            //
        }

        return true;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Services';
    }

    protected function getStub(): string
    {
        if ($this->option('provider')) {
            return $this->resolveStubPath('services/service.implemented.stub');
        }

        return $this->resolveStubPath('services/service.stub');
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
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service already exists'],
            ['provider', null, InputOption::VALUE_NONE, 'Indicates that service come with service provider, interface and testing service class'],
        ];
    }
}

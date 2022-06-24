<?php

namespace WebId\Persil\Console\Commands;

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
        /** @var string $name */
        $name = $this->argument('name');

        $service = Str::replaceFirst(
            'Testing',
            '',
            Str::studly(class_basename($name))
        ) . 'Contract';

        $stub = str_replace(['DummyClassContract', '{{ classContract }}', '{{classContract}}'], $service, $stub);

        return $this;
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service testing already exists'],
        ];
    }
}

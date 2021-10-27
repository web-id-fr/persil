<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceProviderCommand extends GeneratorCommand
{
    /** @var string */
    protected $name = 'make:service:provider';

    /** @var string */
    protected $description = 'Create a new service provider class';

    /** @var string */
    protected $type = 'Provider';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Providers';
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this
            ->replaceServicesNamespace($stub)

            ->replaceServiceContract($stub)
            ->replaceServiceTesting($stub)
            ->replaceService($stub)
            ->replaceVariable($stub)

            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('services/service.provider.stub');
    }

    protected function replaceServicesNamespace(string &$stub): self
    {
        $namespace = Str::replace('/', '\\', $this->argument('path') ?? 'App/Services');

        $stub = str_replace(['DummyServicesNamespace', '{{ servicesNamespace }}', '{{servicesNamespace}}'], $namespace, $stub);

        return $this;
    }

    protected function replaceServiceContract(string &$stub): self
    {
        $service = Str::replaceFirst(
            'Provider',
            '',
            Str::studly(class_basename($this->argument('name')))
        ) . 'Contract';

        $stub = str_replace(['DummyServiceContract', '{{ serviceContract }}', '{{serviceContract}}'], $service, $stub);

        return $this;
    }

    protected function replaceServiceTesting(string &$stub): self
    {
        $service = Str::replaceFirst(
            'Provider',
            '',
            Str::studly(class_basename($this->argument('name')))
        ) . 'Testing';

        $stub = str_replace(['DummyServiceTesting', '{{ serviceTesting }}', '{{serviceTesting}}'], $service, $stub);

        return $this;
    }

    protected function replaceService(string &$stub): self
    {
        $service = Str::replaceFirst(
            'Provider',
            '',
            Str::studly(class_basename($this->argument('name')))
        );

        $stub = str_replace(['DummyService', '{{ service }}', '{{service}}'], $service, $stub);

        return $this;
    }

    protected function replaceVariable(string &$stub): self
    {
        $service = Str::camel(Str::replaceFirst(
            'ServiceProvider',
            '',
            Str::studly(class_basename($this->argument('name')))
        ));

        $stub = str_replace(['DummyVariable', '{{ variable }}', '{{variable}}'], $service, $stub);

        return $this;
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the provider already exists'],
        ];
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
            ['path', InputArgument::OPTIONAL, 'The path of services'],
        ];
    }
}

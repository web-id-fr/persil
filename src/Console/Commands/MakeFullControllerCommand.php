<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeFullControllerCommand extends GeneratorCommand
{
    /** @var string */
    protected $name = 'make:full-controller';

    /** @var string */
    protected $description = 'Create a new controller pre-complete class';

    /** @var string */
    protected $type = 'Controller';

    protected function buildClass($name, string $stub = null): string
    {
        /** @var string $type */
        $type = $this->option('type');
        $stub = $this->files->get($this->resolveStubPath("controllers/$type.stub"));

        return $this->replaceNamespace($stub, $name)
            ->replaceClassModel($stub)
            ->replacePluralVariableModel($stub)
            ->replaceVariableModel($stub)
            ->replaceClass($stub, $name);
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Controllers';
    }

    protected function getStub(): string
    {
        return '';
    }

    protected function replaceClassModel(string &$stub): self
    {
        /** @var string $name */
        $name = $this->argument('name');

        $model = Str::replaceFirst(
            'Controller',
            '',
            Str::studly(class_basename($name))
        );

        $stub = str_replace(['DummyClassModel', '{{ classModel }}', '{{classModel}}'], $model, $stub);

        return $this;
    }

    protected function replaceVariableModel(string &$stub): self
    {
        /** @var string $name */
        $name = $this->argument('name');

        $variable = Str::replaceFirst(
            'Controller',
            '',
            Str::camel(Str::studly(class_basename($name)))
        );

        $stub = str_replace(['DummyVariableModel', '{{ variableModel }}', '{{variableModel}}'], $variable, $stub);

        return $this;
    }

    protected function replacePluralVariableModel(string &$stub): self
    {
        /** @var string $name */
        $name = $this->argument('name');

        $variable = Str::plural(Str::replaceFirst(
            'Controller',
            '',
            Str::camel(Str::studly(class_basename($name)))
        ));

        $stub = str_replace([
            'DummyPluralVariableModel',
            '{{ pluralVariableModel }}',
            '{{pluralVariableModel}}'
        ], $variable, $stub);

        return $this;
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the repository already exists'],
            ['type', 'inertia', InputOption::VALUE_REQUIRED, 'Type of controller (inertia, blade). Default: inertia'],
        ];
    }
}

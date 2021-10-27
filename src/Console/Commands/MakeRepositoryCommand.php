<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeRepositoryCommand extends GeneratorCommand
{
    /** @var string */
    protected $name = 'make:repository';

    /** @var string */
    protected $description = 'Create a new repository class';

    /** @var string */
    protected $type = 'Repository';

    protected function buildClass($name, $stub = null): string
    {
        $options = collect($this->getOptions())
            ->pluck(0, 0)
            ->map(fn ($value, $key) => $this->option($key))
            ->filter()
            ->toArray();
        unset($options['resource']);
        unset($options['force']);

        if ($this->option('resource')) {
            $options['all'] = true;
            $options['store'] = true;
            $options['update'] = true;
            $options['delete'] = true;
        }

        $stub = $this->files->get($this->resolveStubPath('repositories/start.stub'));

        foreach ($options as $option => $value) {
            $stub .= $this->files->get($this->resolveStubPath('repositories/' . $option . '.stub'));
        }

        $stub .= $this->files->get($this->resolveStubPath('repositories/end.stub'));

        return $this->replaceNamespace($stub, $name)
            ->replaceClassModel($stub)
            ->replaceVariableModel($stub)
            ->replaceClass($stub, $name);
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Repositories';
    }

    protected function getStub(): string
    {
        return '';
    }

    protected function replaceClassModel(string &$stub): self
    {
        $model = Str::replaceFirst(
            'Repository',
            '',
            Str::studly(class_basename($this->argument('name')))
        );

        $stub = str_replace(['DummyClassModel', '{{ classModel }}', '{{classModel}}'], $model, $stub);

        return $this;
    }

    protected function replaceVariableModel(string &$stub): self
    {
        $variable = Str::replaceFirst(
            'Repository',
            '',
            Str::camel(Str::studly(class_basename($this->argument('name'))))
        );

        $stub = str_replace(['DummyVariableModel', '{{ variableModel }}', '{{variableModel}}'], $variable, $stub);

        return $this;
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the repository already exists'],
            ['resource', null, InputOption::VALUE_NONE, 'Indicates that repository have all of this methods : all, store, update, delete'],
            ['all', null, InputOption::VALUE_NONE, 'Indicates that repository have "all" method'],
            ['store', null, InputOption::VALUE_NONE, 'Indicates that repository have "store" method'],
            ['update', null, InputOption::VALUE_NONE, 'Indicates that repository have "update" method'],
            ['delete', null, InputOption::VALUE_NONE, 'Indicates that repository have "delete" method'],
            ['find', null, InputOption::VALUE_NONE, 'Indicates that repository have "find" method'],
        ];
    }
}

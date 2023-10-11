<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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

    public const NAMESPACES_FOR_OPTIONS = [
        'all' => [
            Collection::class,
        ],
        'find' => [
            ModelNotFoundException::class,
        ],
        'cache' => [
            Cache::class,
        ],
    ];

    protected function buildClass($name, string $stub = null): string
    {
        $optionsNamespaces = $this->getNamespacesTextForOptions(array_keys($this->options()));

        $stub = $this->files->get($this->resolveStubPath('repositories/start.stub'));
        $cacheFolder = $this->option('cache') ? 'cache' : '';

        foreach ($this->getMethods() as $method => $value) {
            $stub .= $this->files->get($this->resolveStubPath("repositories/$cacheFolder/$method.stub"));
        }

        $stub .= $this->files->get($this->resolveStubPath('repositories/end.stub'));

        return $this->replaceNamespace($stub, $name)
            ->replaceOptionsNamespace($stub, $optionsNamespaces)
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
        /** @var string $name */
        $name = $this->argument('name');

        $model = Str::replaceFirst(
            'Repository',
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
            'Repository',
            '',
            Str::camel(Str::studly(class_basename($name)))
        );

        $stub = str_replace(['DummyVariableModel', '{{ variableModel }}', '{{variableModel}}'], $variable, $stub);

        return $this;
    }

    protected function replaceOptionsNamespace(string &$stub, string $optionsNamespaces): self
    {
        $stub = str_replace(['DummyOptionsNamespaces'], $optionsNamespaces, $stub);

        return $this;
    }

    /**
     * @return array<int, array<int, mixed>>
     */
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
            ['cache', null, InputOption::VALUE_NONE, 'Indicates that repository use "cache" method'],
        ];
    }

    /**
     * @param array<int, string> $options
     * @return string
     */
    protected function getNamespacesTextForOptions(array $options): string
    {
        $namespaces = collect();

        foreach ($options as $option) {
            if (! empty(self::NAMESPACES_FOR_OPTIONS[$option])) {
                foreach (self::NAMESPACES_FOR_OPTIONS[$option] as $namespace) {
                    $namespaces->push($namespace);
                }
            }
        }

        return $namespaces->unique()
            ->map(fn ($namespace) => 'use ' . $namespace . ';')
            ->implode("\n");
    }

    /**
     * @return array<string, bool>
     */
    protected function getMethods(): array
    {
        $methods = collect($this->getOptions())
            ->pluck(0, "0")
            ->map(fn ($value, $key) => $this->option($key))
            ->filter()
            ->toArray();
        unset($methods['resource']);
        unset($methods['force']);
        unset($methods['cache']);

        if ($this->option('resource')) {
            $methods['all'] = true;
            $methods['store'] = true;
            $methods['update'] = true;
            $methods['delete'] = true;
        }

        return $methods;
    }
}

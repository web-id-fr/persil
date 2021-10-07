<?php

namespace WebId\Persil\Console\Commands;

use Symfony\Component\Console\Input\InputOption;

class MakeRepositoryCommand extends MakeCommandAbstract
{
    /** @var string */
    protected $name = 'make:repository';

    /** @var string */
    protected $description = 'Create a new repository class';

    /** @var string */
    protected $type = 'Repository';

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $options = collect($this->getOptions())
            ->pluck(0, 0)
            ->map(fn ($value, $key) => $this->option($key))
            ->filter()
            ->toArray();
        unset($options['resource']);

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
            ->replaceClassModel($stub, $name)
            ->replaceVariableModel($stub, $name)
            ->replaceClass($stub, $name);
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Repositories';
    }

    protected function getOptions(): array
    {
        return [
            ['resource', null, InputOption::VALUE_NONE, 'Indicates that repository have all of this methods : all, store, update, delete'],
            ['all', null, InputOption::VALUE_NONE, 'Indicates that repository have "all" method'],
            ['store', null, InputOption::VALUE_NONE, 'Indicates that repository have "store" method'],
            ['update', null, InputOption::VALUE_NONE, 'Indicates that repository have "update" method'],
            ['delete', null, InputOption::VALUE_NONE, 'Indicates that repository have "delete" method'],
            ['find', null, InputOption::VALUE_NONE, 'Indicates that repository have "find" method'],
        ];
    }

    protected function getStub(): string
    {
        return '';
    }
}

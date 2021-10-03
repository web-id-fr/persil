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

    protected function getStub(): string
    {
        if ($this->option('crud')) {
            return $this->resolveStubPath('repository.crud.stub');
        }

        return $this->resolveStubPath('repository.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Repositories';
    }

    protected function getOptions(): array
    {
        return [
            ['crud', null, InputOption::VALUE_NONE, 'Indicates that repository have all of this methods : all, find, store, update, delete'],
        ];
    }
}

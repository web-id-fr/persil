<?php

namespace WebId\Persil\Console\Commands;

class MakeServiceCommand extends MakeCommandAbstract
{
    /** @var string */
    protected $name = 'make:service';

    /** @var string */
    protected $description = 'Create a new service class';

    /** @var string */
    protected $type = 'Service';

    protected function getStub(): string
    {
        return $this->resolveStubPath('service.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Services';
    }

    protected function getOptions(): array
    {
        return [];
    }
}

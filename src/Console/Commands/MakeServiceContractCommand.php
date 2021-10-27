<?php

namespace WebId\Persil\Console\Commands;

use Symfony\Component\Console\Input\InputOption;

class MakeServiceContractCommand extends GeneratorCommand
{
    /** @var string */
    protected $name = 'make:service:contract';

    /** @var string */
    protected $description = 'Create a new service contract class';

    /** @var string */
    protected $type = 'Service';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Services';
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('services/service.contract.stub');
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service contract already exists'],
        ];
    }
}

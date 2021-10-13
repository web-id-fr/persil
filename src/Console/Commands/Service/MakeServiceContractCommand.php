<?php

namespace WebId\Persil\Console\Commands\Service;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use WebId\Persil\Console\Commands\MakeCommandAbstract;

class MakeServiceContractCommand extends MakeCommandAbstract
{
    /** @var string */
    protected $name = 'make:service:contract';

    /** @var string */
    protected $description = 'Create a new service contract interface';

    /** @var string */
    protected $type = 'Contract';

    protected function getStub(): string
    {
        return $this->resolveStubPath('services/service.contract.stub');
    }

    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return config('persil.driver') === 'testing'
            ? __DIR__ . '/../../../../tests/trash/' . str_replace('\\', '/', $name).'.php'
            : $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getModelClassName(): string
    {
        $class = $this->getNameInput();

        return substr($class, 0, -strlen('ServiceContract'));
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . "\Services\\" . $this->getModelClassName();
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the contract already exists'],
        ];
    }
}
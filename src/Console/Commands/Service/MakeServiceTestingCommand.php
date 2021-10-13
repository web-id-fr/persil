<?php

namespace WebId\Persil\Console\Commands\Service;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use WebId\Persil\Console\Commands\MakeCommandAbstract;

class MakeServiceTestingCommand extends MakeCommandAbstract
{
    /** @var string */
    protected $name = 'make:service:testing';

    /** @var string */
    protected $description = 'Create a new service testing class';

    /** @var string */
    protected $type = 'Testing';

    protected function getStub(): string
    {
        return $this->resolveStubPath('services/service.testing.stub');
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

        return substr($class, 0, -strlen('ServiceTesting'));
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . "\Services\\" . $this->getModelClassName();
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service testing already exists'],
        ];
    }
}

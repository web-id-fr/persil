<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceCommand extends GeneratorCommand
{
    /** @var string */
    protected $name = 'make:service';

    /** @var string */
    protected $description = 'Create a new service class';

    /** @var string */
    protected $type = 'Service';

    public function handle(): bool
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        if ($this->option('provider')) {
            $arguments = [];
            if ($this->option('force')) {
                $arguments['--force'] = true;
            }

            $arguments['name'] = $this->getNameInput() . 'Contract';
            $this->call('make:service:contract', $arguments);

            $arguments['name'] = $this->getNameInput() . 'Testing';
            $this->call('make:service:testing', $arguments);

            $argumentExploded = explode('/', $this->getNameInput());
            $arguments['name'] = Arr::last($argumentExploded) . 'Provider';
            if (count($argumentExploded) > 1) {
                unset($argumentExploded[array_key_last($argumentExploded)]);
                $arguments['path'] = 'App/Services/' . implode('/', $argumentExploded);
            }
            $this->call('make:service:provider', $arguments);
        }

        return true;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Services';
    }

    protected function getStub(): string
    {
        if ($this->option('provider')) {
            return $this->resolveStubPath('services/service.implemented.stub');
        }

        return $this->resolveStubPath('services/service.stub');
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service already exists'],
            ['provider', null, InputOption::VALUE_NONE, 'Indicates that service come with service provider, interface and testing service class'],
        ];
    }
}

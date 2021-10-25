<?php

namespace WebId\Persil\Console\Commands\Service;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use WebId\Persil\Console\Commands\MakeCommandAbstract;

class MakeServiceCommand extends MakeCommandAbstract
{
    /** @var string */
    protected $name = 'make:service';

    /** @var string */
    protected $description = 'Create a new service class';

    /** @var string */
    protected $type = 'Service';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): bool
    {
        $handle = parent::handle();

        if ($handle === false) {
            return false;
        }

        if ($this->option('provider')) {
            $arguments = [];

            if ($this->option('force')) {
                $arguments['--force'] = true;
            }

            $arguments['name'] = $this->getNameInput() . 'Provider';
            $this->call('make:service:provider', $arguments);

            $arguments['name'] = $this->getNameInput() . 'Contract';
            $this->call('make:service:contract', $arguments);

            $arguments['name'] = $this->getNameInput() . 'Testing';
            $this->call('make:service:testing', $arguments);

            $modelClassName = $this->getModelClassName();
            $this->warn("Don't forget to add the provider \"" . $modelClassName . "ServiceProvider\" in : config/app.php");
            $this->warn("Don't forget to add \"" . Str::camel($modelClassName) . ".driver\" in : config/services.php");
        }

        return true;
    }

    protected function getStub(): string
    {
        if ($this->option('provider')) {
            return $this->resolveStubPath('services/service.implemented.stub');
        }

        return $this->resolveStubPath('services/service.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . "\Services\\" . $this->getModelClassName();
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the service already exists'],
            ['provider', null, InputOption::VALUE_NONE, 'Indicates that service come with service provider, interface and testing service class'],
        ];
    }
}

<?php

namespace WebId\Persil\Console\Commands\Service;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Config;
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
            $this->call('make:service:provider', ['name' => $this->getNameInput() . 'Provider']);
            $this->call('make:service:contract', ['name' => $this->getNameInput() . 'Contract']);
            $this->call('make:service:testing', ['name' => $this->getNameInput() . 'Testing']);

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
            ['provider', null, InputOption::VALUE_NONE, 'Indicates that service come with service provider, interface and testing service class'],
        ];
    }

    private function setConfig()
    {
        $array = Config::get('customization');
        if (Input::has('ip_address')) {
            $array['ip_settings']['ip_address'] = Input::get('ip_address');
        }
        $array['ip_settings']['ip_check'] = Input::has('ip_check') ? 1 : 0;
        $data = var_export($array, 1);
        if (File::put(app_path() . '/config/customization.php', "<?php\n return $data ;")) {
            // Successful, return Redirect...
        }
    }
}

<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

abstract class MakeCommandAbstract extends GeneratorCommand
{
    abstract protected function getStub(): string;

    /**
     * @throws FileNotFoundException
     */
    public function handle(): bool
    {
        $handle = parent::handle();

        if ($handle === false) {
            return false;
        }

        return true;
    }

    protected function resolveStubPath(string $stub): string
    {
        $customPath = config('persil.driver') === 'testing'
            ? __DIR__ . '/../../../tests/trash/' . $stub
            : $this->laravel->basePath("stubs/vendor/persil/" . $stub);

        return file_exists($customPath)
            ? $customPath
            : __DIR__ . "/../../Stubs/Makes/" . $stub;
    }

    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return config('persil.driver') === 'testing'
            ? __DIR__ . '/../../../tests/trash/' . str_replace('\\', '/', $name).'.php'
            : $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    /**
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceClassModel($stub, $name)
            ->replaceVariableModel($stub, $name)
            ->replaceClass($stub, $name);
    }

    protected function replaceClassModel(string &$stub, string $name): self
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $model = substr($class, 0, -strlen($this->type));

        $stub = str_replace(['DummyClassModel', '{{ classModel }}', '{{classModel}}'], $model, $stub);

        return $this;
    }

    protected function replaceVariableModel(string &$stub, string $name): self
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $variable = Str::camel(substr($class, 0, -strlen($this->type)));

        $stub = str_replace(['DummyVariableModel', '{{ variableModel }}', '{{variableModel}}'], $variable, $stub);

        return $this;
    }
}

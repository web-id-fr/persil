<?php

namespace WebId\Persil\Console\Commands;

use Illuminate\Console\GeneratorCommand as OriginalGeneratorCommand;
use Illuminate\Support\Str;

abstract class GeneratorCommand extends OriginalGeneratorCommand
{
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
            : $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php'; // @phpstan-ignore-line
    }
}

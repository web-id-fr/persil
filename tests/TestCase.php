<?php

namespace WebId\Persil\Tests;

use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as Orchestra;
use WebId\Persil\PersilServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            PersilServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('persil.driver', 'testing');
    }

    protected function getSha1FileOnTrashFolder(string $filePath): string
    {
        return sha1_file(__DIR__ . '/trash/' . $filePath);
    }

    protected function deleteTrashFolder(): void
    {
        File::deleteDirectory(__DIR__ . '/trash');
    }

    protected function assertFileExistsOnTrashFolder(string $filePath): void
    {
        $this->assertFileExists(__DIR__ . '/trash/' . $filePath);
    }

}

<?php

namespace WebId\Persil\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestCaseWithDatabase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'WebId\\Persil\\Tests\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__ . '/Database/migrations/create_users_table.php';

        (new \CreateUsersTable())->up();
    }
}

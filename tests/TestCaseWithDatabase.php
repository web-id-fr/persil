<?php

namespace WebId\Persil\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

        config()->set('database.default', 'mysql');
        config()->set('database.connections.mysql', [
            'driver' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => [],
        ]);

        $this->dropTables();

        include_once __DIR__ . '/Database/migrations/create_users_table.php';

        (new \CreateUsersTable())->up();
    }

    private function dropTables(): void
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            Schema::drop($table->Tables_in_persil);
        }
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");
    }
}

<?php

namespace WebId\Persil\Tests\Unit\Repositories;

use App\Repositories\UserRepository;
use WebId\Persil\Tests\TestCaseWithDatabase;

class RepositoryCacheTest extends TestCaseWithDatabase
{
    use RepositoryTestTrait;

    private UserRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        include_once __DIR__ . '/../../Models/User.php';

        $this->artisan('make:repository UserRepository --force --resource --find --cache');
        include_once __DIR__ . '/../../trash/Repositories/UserRepository.php';
        $this->repository = app(UserRepository::class);
    }
}

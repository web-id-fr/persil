<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class MakeRepositoryCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTrashFolder();
    }

    /** @test */
    public function it_can_make_basic_repository_file()
    {
        $this->artisan('make:repository UserRepository')
            ->assertExitCode(1);

        $this->assertFileExistsOnTrashFolder('Repositories/UserRepository.php');
    }

    /** @test */
    public function it_can_make_resource_repository_file()
    {
        $this->artisan('make:repository UserRepository --resource')
            ->assertExitCode(1);

        $this->assertFileExistsOnTrashFolder('Repositories/UserRepository.php');
    }

    /** @test */
    public function it_can_make_repository_file_with_juste_all_method()
    {
        $this->artisan('make:repository UserRepository --all')
            ->assertExitCode(1);

        $this->assertFileExistsOnTrashFolder('Repositories/UserRepository.php');
    }

    /** @test */
    public function it_can_make_repository_file_with_multiple_methods()
    {
        $this->artisan('make:repository UserRepository --all --store')
            ->assertExitCode(1);

        $this->assertFileExistsOnTrashFolder('Repositories/UserRepository.php');
    }
}

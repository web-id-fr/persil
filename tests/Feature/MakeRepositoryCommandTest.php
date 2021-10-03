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
    public function it_can_make_crud_repository_file()
    {
        $this->artisan('make:repository UserRepository --crud')
            ->assertExitCode(1);

        $this->assertFileExistsOnTrashFolder('Repositories/UserRepository.php');
    }
}

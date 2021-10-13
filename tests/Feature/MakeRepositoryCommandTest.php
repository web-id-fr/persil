<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class MakeRepositoryCommandTest extends TestCase
{
    const OPTIONS = [
        'resource',
        'all',
        'store',
        'update',
        'delete',
        'find',
    ];

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
    public function it_can_make_repository_file_for_each_options()
    {
        foreach (self::OPTIONS as $option) {
            $this->artisan('make:repository UserRepository --' . $option)
                ->assertExitCode(1);

            $this->assertFileExistsOnTrashFolder('Repositories/UserRepository.php');
            $this->deleteTrashFolder();
        }
    }

    /** @test */
    public function it_can_make_repository_file_with_multiple_methods()
    {
        $this->artisan('make:repository UserRepository --all --store')
            ->assertExitCode(1);

        $this->assertFileExistsOnTrashFolder('Repositories/UserRepository.php');
    }

    /** @test */
    public function it_can_make_by_force_repository_file()
    {
        $this->artisan('make:repository UserRepository --all --store')
            ->assertExitCode(1);

        $previousFileSha1 = $this->getSha1FileOnTrashFolder('Repositories/UserRepository.php');

        $this->artisan('make:repository UserRepository --delete --force')
            ->assertExitCode(1);

        $this->assertNotEquals($previousFileSha1, $this->getSha1FileOnTrashFolder('Repositories/UserRepository.php'));
    }
}

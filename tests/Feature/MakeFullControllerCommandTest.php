<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class MakeFullControllerCommandTest extends TestCase
{
    public const TYPES = [
        'inertia',
        'blade'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTrashFolder();
    }

    /** @test */
    public function it_can_make_controller_file_for_each_types()
    {
        foreach (self::TYPES as $type) {
            $this->artisan("make:full-controller UserController --type=$type");

            $this->assertFileExistsOnTrashFolder('Controllers/UserController.php');
            $this->deleteTrashFolder();
        }
    }
}

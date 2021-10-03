<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class MakeServiceCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTrashFolder();
    }

    /** @test */
    public function it_can_make_service_file()
    {
        $this->artisan('make:service PaymentService')
            ->assertExitCode(1);

        $this->assertFileExistsOnTrashFolder('Services/PaymentService.php');
    }
}

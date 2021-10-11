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

        $this->assertFileExistsOnTrashFolder('Services/Payment/PaymentService.php');
    }

    /** @test */
    public function it_can_make_service_file_with_provider_option()
    {
        $this->artisan('make:service PaymentService --provider')
            ->assertExitCode(1);

        $this->assertFileExistsOnTrashFolder('Providers/PaymentServiceProvider.php');
        $this->assertFileExistsOnTrashFolder('Services/Payment/PaymentService.php');
        $this->assertFileExistsOnTrashFolder('Services/Payment/PaymentServiceContract.php');
        $this->assertFileExistsOnTrashFolder('Services/Payment/PaymentServiceTesting.php');
    }
}

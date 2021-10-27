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
        $this->artisan('make:service PaymentService');

        $this->assertFileExistsOnTrashFolder('Services/PaymentService.php');
    }

    /** @test */
    public function it_can_make_service_file_with_complex_path()
    {
        $this->artisan('make:service Payments/Online/StripePaymentService');

        $this->assertFileExistsOnTrashFolder('Services/Payments/Online/StripePaymentService.php');
    }

    /** @test */
    public function it_can_make_service_file_with_provider_option()
    {
        $this->artisan('make:service PaymentService --provider');

        $this->assertFileExistsOnTrashFolder('Providers/PaymentServiceProvider.php');
        $this->assertFileExistsOnTrashFolder('Services/Payment/PaymentService.php');
        $this->assertFileExistsOnTrashFolder('Services/Payment/PaymentServiceContract.php');
        $this->assertFileExistsOnTrashFolder('Services/Payment/PaymentServiceTesting.php');
    }

    /** @test */
    public function it_can_make_by_force_service_file()
    {
        $this->artisan('make:service PaymentService');

        $this->artisan('make:service PaymentService --force');

        $this->assertFileExistsOnTrashFolder('Services/PaymentService.php');
    }
}

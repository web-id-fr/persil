<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class MakeServiceProviderCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTrashFolder();
    }

    /** @test */
    public function it_can_make_service_provider_file()
    {
        $this->artisan('make:service:provider PaymentServiceProvider');

        $this->assertFileExistsOnTrashFolder('Providers/PaymentServiceProvider.php');
    }

    /** @test */
    public function it_can_make_service_provider_file_with_complex_path()
    {
        $this->artisan('make:service:provider Payments/Online/StripePaymentServiceProvider App/Services/Payments/Online');

        $this->assertFileExistsOnTrashFolder('Providers/Payments/Online/StripePaymentServiceProvider.php');
    }

    /** @test */
    public function it_can_make_by_force_service_provider_file()
    {
        $this->artisan('make:service:provider PaymentServiceProvider');

        $this->artisan('make:service:provider PaymentServiceProvider --force');

        $this->assertFileExistsOnTrashFolder('Providers/PaymentServiceProvider.php');
    }
}

<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class MakeServiceTestingCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTrashFolder();
    }

    /** @test */
    public function it_can_make_service_testing_file()
    {
        $this->artisan('make:service:testing PaymentServiceTesting');

        $this->assertFileExistsOnTrashFolder('Services/PaymentServiceTesting.php');
    }

    /** @test */
    public function it_can_make_service_testing_file_with_complex_path()
    {
        $this->artisan('make:service:testing Payments/Online/StripePaymentServiceTesting');

        $this->assertFileExistsOnTrashFolder('Services/Payments/Online/StripePaymentServiceTesting.php');
    }

    /** @test */
    public function it_can_make_by_force_testing_contract_file()
    {
        $this->artisan('make:service:testing PaymentServiceTesting');

        $this->artisan('make:service:testing PaymentServiceTesting --force');

        $this->assertFileExistsOnTrashFolder('Services/PaymentServiceTesting.php');
    }
}

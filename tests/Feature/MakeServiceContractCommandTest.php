<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class MakeServiceContractCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTrashFolder();
    }

    /** @test */
    public function it_can_make_service_contract_file()
    {
        $this->artisan('make:service:contract PaymentServiceContract');

        $this->assertFileExistsOnTrashFolder('Services/PaymentServiceContract.php');
    }

    /** @test */
    public function it_can_make_service_contract_file_with_complex_path()
    {
        $this->artisan('make:service:contract Payments/Online/StripePaymentServiceContract');

        $this->assertFileExistsOnTrashFolder('Services/Payments/Online/StripePaymentServiceContract.php');
    }

    /** @test */
    public function it_can_make_by_force_service_contract_file()
    {
        $this->artisan('make:service:contract PaymentServiceContract');

        $this->artisan('make:service:contract PaymentServiceContract --force');

        $this->assertFileExistsOnTrashFolder('Services/PaymentServiceContract.php');
    }
}

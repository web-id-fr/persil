<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class FreshInstallPublishTest extends TestCase
{
    const FRESH_INSTALL_FILE_PATHS = [
        'app/Console/Kernel.php',
        'app/Exceptions/Handler.php',
        'app/Http/Middleware/EncryptCookies.php',
        'app/Http/Middleware/PreventRequestsDuringMaintenance.php',
        'app/Http/Middleware/TrimStrings.php',
        'app/Http/Middleware/TrustHosts.php',
        'app/Http/Middleware/TrustProxies.php',
        'app/Http/Middleware/VerifyCsrfToken.php',
        'app/Http/Kernel.php',
        'app/Models/User.php',
        'app/Providers/AuthServiceProvider.php',
        'app/Providers/EventServiceProvider.php'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTrashFolder();
    }

    /** @test */
    public function it_can_publish_fresh_install()
    {
        $this->artisan('vendor:publish --tag=fresh-install')
            ->assertExitCode(0);

        foreach (self::FRESH_INSTALL_FILE_PATHS as $filePath) {
            $this->assertFileExistsOnTrashFolder($filePath);
        }
    }
}

<?php

namespace WebId\Persil\Tests\Feature;

use WebId\Persil\Tests\TestCase;

class CustomLaravelStubsPublishTest extends TestCase
{
    const CUSTOM_STUBS_FILE_PATHS = [
        'console.stub',
        'controller.api.stub',
        'controller.invokable.stub',
        'controller.model.api.stub',
        'controller.model.stub',
        'controller.nested.api.stub',
        'controller.nested.stub',
        'controller.plain.stub',
        'controller.stub',
        'event.stub',
        'factory.stub',
        'job.queued.stub',
        'job.stub',
        'mail.stub',
        'middleware.stub',
        'migration.create.stub',
        'migration.stub',
        'migration.update.stub',
        'model.pivot.stub',
        'model.stub',
        'notification.stub',
        'request.stub',
        'resource.stub',
        'resource-collection.stub',
        'rule.stub',
        'seeder.stub',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTrashFolder();
    }

    /** @test */
    public function it_can_publish_custom_laravel_stubs()
    {
        $this->artisan('vendor:publish --tag=custom-laravel-stubs')
            ->assertExitCode(0);

        foreach (self::CUSTOM_STUBS_FILE_PATHS as $filePath) {
            $this->assertFileExistsOnTrashFolder($filePath);
        }
    }
}

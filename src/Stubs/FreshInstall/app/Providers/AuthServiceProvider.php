<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<string>
     */
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}

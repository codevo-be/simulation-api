<?php

namespace Diji\Billing;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerTenantMigrations();

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');

        $this->loadViewsFrom(__DIR__ . '/views', 'billing');
    }

    public function boot()
    {
    }

    protected function registerTenantMigrations(): void
    {
        if (!file_exists(config_path('tenancy.php'))) {
            return;
        }

        $tenantMigrationsPath = __DIR__ . '/Database/Migrations/tenant';
        $existingPaths = config('tenancy.migration_parameters.--path', []);

        config([
            'tenancy.migration_parameters.--path' => array_unique([...$existingPaths, $tenantMigrationsPath]),
        ]);
    }
}

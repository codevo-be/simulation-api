<?php

namespace DigicoSimulation;

use Illuminate\Support\ServiceProvider;

class PhpServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerTenantMigrations();

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations'); //TODO Y'a pas de migration database dans le module ? Il faut le rajouter ou mettre dnasun général ?

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    protected function registerTenantMigrations(): void
    {
        if (!file_exists(config_path('tenancy.php'))) {
            return;
        }

        $tenantMigrationPath = __DIR__ . '/Database/Migrations/tenant';
        $existingPaths = config('tenancy.migration_parameters.--path', []);

        config([
            'tenancy.migration_parameters.--path' => array_unique([...$existingPaths, $tenantMigrationPath]),
        ]);
    }
}

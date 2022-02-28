<?php

namespace Takshak\Adash\Providers;
use Illuminate\Support\ServiceProvider;
use Takshak\Adash\Console\InstallCommand;
use Takshak\Adash\Console\MakeCrudCommand;


class AdashServiceProvider extends ServiceProvider
{
    public $baseStubs = __DIR__.'/../../stubs/';

    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([ InstallCommand::class, MakeCrudCommand::class ]);
        $this->publishFiles();
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [InstallCommand::class];
    }

    public function register()
    {

    }

    public function publishFiles()
    {
        $controllerStubs = $this->baseStubs.'app/Http/Controllers/';
        $databaseStubs = $this->baseStubs.'database/';

        $this->publishes([
            $controllerStubs.'HomeController.php' => app_path('Http/Controllers/HomeController.php'),
            $controllerStubs.'Admin' => app_path('Http/Controllers/Admin'),

            $databaseStubs.'factories' => database_path('factories'),
            $databaseStubs.'seeders' => database_path('seeders'),
            $databaseStubs.'seeders/DatabaseSeeder.php' => database_path('seeders/DatabaseSeeder.php'),

            $this->baseStubs.'assets' => public_path('assets'),
            $this->baseStubs.'resources/views' => resource_path('views'),
            $this->baseStubs.'app/Models' => app_path('Models'),
            $this->baseStubs.'app/View' => app_path('View'),
	        $this->baseStubs.'routes/admin.php' => base_path('routes/admin.php'),
            $this->baseStubs.'routes/web.php' => base_path('routes/web.php'),

            __DIR__.'/../../database/migrations' => database_path('migrations'),

	    ], 'adash-default');

        $this->publishes([
            $this->baseStubs.'modules/faqs/Controllers' => app_path('Http/Controllers/Admin'),
            $this->baseStubs.'modules/faqs/migrations' => database_path('migrations'),
            $this->baseStubs.'modules/faqs/factories' => database_path('factories'),
            $this->baseStubs.'modules/faqs/seeders' => database_path('seeders'),
            $this->baseStubs.'modules/faqs/Models' => app_path('Models'),
            $this->baseStubs.'modules/faqs/views/admin' => resource_path('views/admin'),

        ], 'adash-faqs');

        $this->publishes([
            $this->baseStubs.'modules/pages/Controllers' => app_path('Http/Controllers/Admin'),
            $this->baseStubs.'modules/pages/migrations' => database_path('migrations'),
            $this->baseStubs.'modules/pages/factories' => database_path('factories'),
            $this->baseStubs.'modules/pages/seeders' => database_path('seeders'),
            $this->baseStubs.'modules/pages/Models' => app_path('Models'),
            $this->baseStubs.'modules/pages/views/admin' => resource_path('views/admin'),

        ], 'adash-pages');

        $this->publishes([
            $this->baseStubs.'modules/testimonials/Controllers' => app_path('Http/Controllers/Admin'),
            $this->baseStubs.'modules/testimonials/migrations' => database_path('migrations'),
            $this->baseStubs.'modules/testimonials/factories' => database_path('factories'),
            $this->baseStubs.'modules/testimonials/seeders' => database_path('seeders'),
            $this->baseStubs.'modules/testimonials/Models' => app_path('Models'),
            $this->baseStubs.'modules/testimonials/views/admin' => resource_path('views/admin'),

        ], 'adash-testimonials');
    }
}

require_once __DIR__ . '/../helpers.php';

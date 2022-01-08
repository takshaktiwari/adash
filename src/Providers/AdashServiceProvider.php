<?php

namespace Takshak\Adash\Providers;
use Illuminate\Support\ServiceProvider;
use Takshak\Adash\Console\InstallCommand;


class AdashServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([ InstallCommand::class, ]);

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->publishFiles();
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
        

        $stubsPath = __DIR__.'/../../stubs/';
        $this->publishes([
            __DIR__.'/../../config/adash.php' => config_path('adash.php'),

	        $stubsPath.'database/seeders' => database_path('seeders'),
	        $stubsPath.'assets' => base_path('assets'),
	        $stubsPath.'resources/views/layouts' => base_path('resources/views/layouts'),
            $stubsPath.'resources/views/admin' => base_path('resources/views/admin'),
	        $stubsPath.'resources/views/components/admin' => resource_path('views/components/admin'),
	        $stubsPath.'app/Http/Controllers' => app_path('Http/Controllers'),
            $stubsPath.'app/Models' => app_path('Models'),
            $stubsPath.'app/View' => app_path('View'),
	        $stubsPath.'routes/admin.php' => base_path('routes/admin.php'),
	        
	    ], 'adash');


    }


}
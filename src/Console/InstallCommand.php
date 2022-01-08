<?php

namespace Takshak\Adash\Console;

use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Takshak\Adash\Providers\AdashServiceProvider;

class InstallCommand extends Command
{
	protected $signature = 'adash:install {install=default}';

    protected $stubsDir = __DIR__.'/../../stubs/';

	public function handle()
    {

        $this->call('breeze:install');

    	(new Filesystem)->ensureDirectoryExists(base_path('assets'));

    	(new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/Admin'));
    	(new Filesystem)->ensureDirectoryExists(app_path('Http/View/Components/Admin'));

    	(new Filesystem)->ensureDirectoryExists(resource_path('views/admin'));
    	(new Filesystem)->ensureDirectoryExists(resource_path('views/components/admin'));

    	$this->publishFiles();
        $this->replaceFiles();
    	$this->migateDB();
        $this->seedDB();
    	
    	$this->info('Adash Setup is successfully install.');
    	$this->info('You will find the login credentials in documentation on github or just check the database seeder');
    	$this->info('https://github.com/takshaktiwari/adash');
    }

    public function publishFiles()
    {
    	$this->call('vendor:publish', ['--provider' => AdashServiceProvider::class ]);
    	$this->line('Adash scaffolding installed successfully.');
    	$this->newLine();
    }

    public function replaceFiles()
    {
        if ($this->argument('install') != 'fresh' && !$this->confirm('Do you wish to replace existing files?')) {
            return true;
        }

        (new Filesystem)->copyDirectory(
            $this->stubsDir.'resources/views/auth',
            resource_path('views/auth')
        );
        $this->info('Breeze auth views are replaced');

        (new Filesystem)->copyDirectory(
            $this->stubsDir.'resources/views/layouts',
            resource_path('views/layouts')
        );
        $this->info('Layouts are replaced');

        (new Filesystem)->copyDirectory(
            $this->stubsDir.'resources/views/components',
            resource_path('views/components')
        );
        $this->info('Components are replaced');

    	copy($this->stubsDir.'app/Models/User.php', base_path('app/Models/User.php'));
        copy($this->stubsDir.'routes/admin.php', base_path('routes/admin.php'));
    	copy($this->stubsDir.'routes/web.php', base_path('routes/web.php'));
        copy($this->stubsDir.'database/seeders/DatabaseSeeder.php', database_path('seeders/DatabaseSeeder.php')); 
        $this->info('Routes, Models and DatabaseSeeder is replaced');      
        
        $this->newLine();
    }

    public function migateDB()
    {
        if ($this->argument('install') == 'fresh') {
            $this->call('migrate:fresh');
            $this->line('Fresh database successfully migrated');
            $this->newLine();
            return true;
        }

        $migrateType = $this->choice(
            'How do you want to migrate?', 
            ['Migrate Normally', 'Migrate Fresh'], 
            0
        );
        if ($migrateType == 'Migrate Fresh') {
            $this->call('migrate:fresh');
            $this->line('Fresh database successfully migrated');

        }else{
            $this->call('migrate');
            $this->line('Database successfully migrated');
        }
    	
    	$this->newLine();
    }

    public function seedDB()
    {
        if ($this->argument('install') != 'fresh' && !$this->confirm('Do you wish to seed database?')) {
            return true;
        }

    	$this->call('db:seed');
    	$this->line('Database successfully seeded');
    	$this->newLine();
    }

    
}
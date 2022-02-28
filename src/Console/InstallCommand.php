<?php

namespace Takshak\Adash\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Takshak\Adash\Traits\Console\PublishFilesTrait;

class InstallCommand extends Command
{
    use PublishFilesTrait;

	protected $signature = 'adash:install {install=default} {--module=*default}';
    protected $module;
    protected $filesystem;
    protected $installType;
    protected $replaceFiles = true;
    protected $migrateFresh = true;
    protected $seedDatabase = true;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem;
    }

	public function handle()
    {
        if ($this->filesystem->missing(config_path('site.php'))) {
            $this->filesystem->copy(__DIR__.'/../../config/config.php', config_path('site.php'));

            $this->info('Configuration file `site.php` is copied. Please specify modules / packages if you want.');
            $this->info('You can change the default packages / modules / settings Or you can continue with defaults.');
            if ($this->confirm('Do you wish to continue with default?', true)) {
                //
            }else{
                $this->error('Quitting!! Run `adash:install` again when all set.');
                exit;
            }
        }

        if (!config('site.install.command', true)) {
            $this->error('SORRY !! Install command has been disabled.');
            exit;
        }

        $this->askQuestions();

        if ($this->installType == 'fresh') {
            $this->filesystem->cleanDirectory(database_path('migrations'));
            $this->filesystem->cleanDirectory(database_path('seeders'));
            $this->filesystem->cleanDirectory(app_path('Models'));
            $this->filesystem->cleanDirectory(resource_path('views/admin'));
        }

        $this->publishFiles();
        $this->migrateDB();
        $this->seedDB();
        $this->installOtherPackages();
        $this->call('storage:link');

        $this->info('Adash Setup is successfully installed.');
    	$this->info('You will find the login credentials in documentation on github or just check the database seeder');
    	$this->info('https://github.com/takshaktiwari/adash');
    }

    public function askQuestions()
    {
        $this->module = config('site.install.modules', ['default']);

        $this->installType = $this->argument('install');
        if ($this->installType != 'fresh') {
            $this->replaceFiles = $this->confirm('Do you wish to replace existing files?', true);
            $this->migrateFresh = $this->confirm('How do you run fresh migrate?', true);
            $this->seedDatabase = $this->confirm('Do you wish to seed database?', true);
        }
    }

    public function publishFiles()
    {
        if ($this->installType == 'fresh' || in_array('default', $this->module)){
            $this->call('breeze:install');
        }

        $options['--force'] = true;
        if ($this->installType != 'fresh') {
            $options = [];
        }
        if ($this->replaceFiles) {
            $options['--force'] = true;
        }

        if (in_array('default', $this->module)) {
            $options['--tag'] = 'adash-default';
            $this->publishDefault($options);
        }
        if (in_array('faqs', $this->module)) {
            $options['--tag'] = 'adash-faqs';
            $this->publishFaqs($options);
        }
        if (in_array('pages', $this->module)) {
            $options['--tag'] = 'adash-pages';
            $this->publishPages($options);
        }
        if (in_array('testimonials', $this->module)) {
            $options['--tag'] = 'adash-testimonials';
            $this->publishTestimonials($options);
        }

    	$this->line('Adash scaffolding installed successfully.');
    	$this->newLine();
    }

    public function migrateDB()
    {
        if ($this->migrateFresh) {
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
        if (!$this->seedDatabase) {
            return false;
        }

        $this->call('db:seed');
        $this->line('Database successfully seeded');
        $this->newLine();
    }

    public function installOtherPackages()
    {
        foreach (config('site.install.packages', []) as $package) {
            $this->info('Installing: '.$package);
            exec('composer require ' . $package);
            $this->info('Other package: ' . $package . ' has been installed');
            $this->success('Run commands associated to this packages.');
            $this->newLine();
        }
        $this->newLine();
    }
}

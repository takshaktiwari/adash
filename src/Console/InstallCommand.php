<?php

namespace Takshak\Adash\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
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
    protected $laravelDebugbar = false;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem;
    }

	public function handle()
    {
        $this->askQuestions();

        if ($this->installType == 'fresh' || in_array('default', $this->module)) {
            $this->filesystem->cleanDirectory(database_path('migrations'));
            $this->filesystem->cleanDirectory(database_path('seeders'));
            $this->filesystem->cleanDirectory(app_path('Models'));
            $this->filesystem->cleanDirectory(resource_path('views/admin'));
        }
    	
        $this->publishFiles();
        $this->installOtherPackages();
        $this->migateDB();
        $this->seedDB();
    	
    	$this->info('Adash Setup is successfully install.');
    	$this->info('You will find the login credentials in documentation on github or just check the database seeder');
    	$this->info('https://github.com/takshaktiwari/adash');
    }

    public function askQuestions()
    {
        $this->module = $this->option('module');
        if (in_array('default', $this->module) && count($this->module) == 1) {
            $userModules = $this->choice(
                'Choose the modules you want to work on ? ',
                [
                    'default'   =>  'Basic admin panel with user management, role and permission',
                    'blog' => 'Blog category, posts and comments', 
                    'faqs' => 'Frequently asked quesions and answers management', 
                    'pages' => 'Informative page management, like: Privary Policy and T&C', 
                    'testimonials' => 'Manage what user say (Testimonials)', 
                    'everything' => 'Get all above modules'
                ],
                'default',
                $maxAttempts = 3,
                $allowMultipleSelections = true,
            );
            $this->module = array_merge($this->module, $userModules);
        }
        
        if (in_array('everything', $this->module)) {
            $this->module = [ 'default', 'blog', 'faqs', 'pages', 'testimonials' ];
        }

        $this->installType = $this->argument('install');
        if ($this->installType != 'fresh') {
            $this->replaceFiles = $this->confirm('Do you wish to replace existing files?', true);
            $this->migrateFresh = $this->confirm('How do you run fresh migrate?', true);
            $this->seedDatabase = $this->confirm('Do you wish to seed database?', true);
            $this->laravelDebugbar = $this->confirm('Do you wish to install "barryvdh/laravel-debugbar"?', false);
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
        if (in_array('blog', $this->module)) {
            $options['--tag'] = 'adash-blog';
            $this->publishBlog($options);
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

    public function migateDB()
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
        if ($this->laravelDebugbar) {
            exec('composer require barryvdh/laravel-debugbar --dev');
        }
    }

    
}
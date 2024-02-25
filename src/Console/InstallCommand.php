<?php

namespace Takshak\Adash\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Takshak\Adash\Traits\Console\PublishFilesTrait;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    use PublishFilesTrait;

    protected $signature = 'adash:install {install=default : Choose from `default` or `fresh`}
    {--modules= : Specify the modules from faqs, pages, testimonials or default or all}
    {--seed-images= : Do you want to seed images, specify 0 / 1 or true / false}';
    protected $modules;
    protected $filesystem;
    protected $installType;
    protected $replaceFiles = true;
    protected $migrateFresh = true;
    protected $seedDatabase = true;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem();
    }

    public function handle()
    {
        if($this->option('modules')){
            if ($this->option('modules') == 'all') {
                $this->modules = ['faqs', 'pages', 'testimonials', 'default'];
            } else {
                $this->modules = array_map(fn ($item) => trim($item), explode(',', $this->option('modules')));
                $this->modules = array_filter($this->modules, function ($item) {
                    return in_array($item, ['faqs', 'pages', 'testimonials', 'default']);
                });
            }
        }else{
            $this->modules = $this->choice(
                "Please specify modules you want to install. \nEg: 0, 1, 3",
                ['default', 'faqs', 'pages', 'testimonials', 'all of above'],
                0,
                null,
                true
            );

            if (in_array('all of above', $this->modules)) {
                $this->modules = ['faqs', 'pages', 'testimonials'];
            }
        }

        $this->modules[] = 'default';
        $this->modules = array_unique($this->modules);

        if ($this->filesystem->missing(config_path('site.php'))) {
            $this->filesystem->copy(__DIR__ . '/../../config/config.php', config_path('site.php'));
        }

        if (!config('site.install.command', true)) {
            $this->error('SORRY !! Install command has been disabled.');
            exit;
        }

        $seedImages = ($this->option('seed-images') != null)
            ? (bool)json_decode(strtolower($this->option('seed-images')))
            : $this->confirm('Do you wish to seed dummy images?', true);

        if ($seedImages) {
            Artisan::call('imager:seed 50');
            $this->line(Artisan::output());
        }

        $this->askQuestions();
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
        $this->installType = $this->argument('install');
        if ($this->installType != 'fresh') {
            $this->replaceFiles = $this->confirm('Do you wish to replace existing files?', true);
            $this->migrateFresh = $this->confirm('How do you run fresh migrate?', true);
            $this->seedDatabase = $this->confirm('Do you wish to seed database?', true);
        }
    }

    public function publishFiles()
    {
        if ($this->installType == 'fresh' || in_array('default', $this->modules)) {
            $this->call('breeze:install', [
                'stack' => 'blade'
            ]);
            $this->filesystem->deleteDirectory(resource_path('views/profile'));
        }

        $options['--force'] = true;
        if ($this->installType != 'fresh') {
            unset($options['--force']);
        }
        if ($this->replaceFiles) {
            $options['--force'] = true;
        }

        if (in_array('default', $this->modules)) {
            $options['--tag'] = 'adash-default';
            $this->publishDefault($options);
        }
        if (in_array('faqs', $this->modules)) {
            $options['--tag'] = 'adash-faqs';
            $this->publishFaqs($options);
        }
        if (in_array('pages', $this->modules)) {
            $options['--tag'] = 'adash-pages';
            $this->publishPages($options);
        }
        if (in_array('testimonials', $this->modules)) {
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
        } else {
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
        $packages = config('site.install.packages', []);
        if (!count($packages)) {
            return true;
        }

        $this->requireComposerPackages($packages);
        $this->newLine();
    }

    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }
}

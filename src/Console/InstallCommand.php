<?php

namespace Takshak\Adash\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Takshak\Adash\Traits\Console\PublishFilesTrait;
use Takshak\Adash\Models\Role;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\form;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

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

    public function handle(): void
    {
        if ($this->option('modules')) {
            if ($this->option('modules') == 'all') {
                $this->modules = ['faqs', 'pages', 'testimonials', 'default'];
            } else {
                $this->modules = array_map(fn($item) => trim($item), explode(',', $this->option('modules')));
                $this->modules = array_filter($this->modules, function ($item) {
                    return \in_array($item, ['faqs', 'pages', 'testimonials', 'default']);
                });
            }
        } else {
            $this->modules = multiselect(
                label: 'Please specify modules you want to install?',
                options: ['default', 'faqs', 'pages', 'testimonials', 'all of above'],
                default: ['all of above'],
            );

            if (\in_array('all of above', $this->modules)) {
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
            : confirm(
                label: 'Do you wish to seed dummy images?',
                default: false
            );

        if ($seedImages) {
            $imagesCount = text(
                label: 'How many dummy images you want to seed?',
                default: '10'
            );
            $imagesCount = (int)$imagesCount;

            info('Seeding dummy images: ' . $imagesCount);
            Artisan::call('imager:seed ' . $imagesCount);
            $this->line(Artisan::output());
        }

        $this->askQuestions();
        $this->publishFiles();

        info('Installing npm packages (Bootstrap 5 + jQuery + DataTables)');
        $result = Process::run(
            'npm install bootstrap bootstrap-icons jquery'
            . ' laravel-datatables-vite'
            . ' datatables.net-bs5 datatables.net-buttons datatables.net-buttons-bs5 datatables.net-responsive-bs5'
        );
        if (!$result->successful()) {
            $this->warn('npm install encountered issues: ' . $result->errorOutput());
        }

        $this->writeViteResources();

        $buildResult = Process::run('npm run build');
        if (!$buildResult->successful()) {
            $this->warn('npm run build encountered issues: ' . $buildResult->errorOutput());
        }

        $this->migrateDB();
        $this->createAdmin();
        $this->seedDB();

        $this->call('storage:link');

        $this->info('Adash Setup is successfully installed.');
        $this->info('You will find the login credentials in documentation on github or just check the database seeder');
        $this->info('https://github.com/takshaktiwari/adash');
    }

    public function askQuestions(): void
    {
        $this->installType = $this->argument('install');
        if ($this->installType != 'fresh') {
            $this->replaceFiles = confirm(
                label: 'Do you wish to replace existing files?',
                default: true
            );

            $this->migrateFresh = confirm(
                label: 'Do you want to run a fresh migration (drops all tables)?',
                default: true
            );

            $this->seedDatabase = confirm(
                label: 'Do you wish to seed the database?',
                default: true
            );
        }
    }

    public function publishFiles(): void
    {
        if ($this->installType == 'fresh' || \in_array('default', $this->modules)) {
            // Breeze copies files into resources/css and resources/js — ensure they exist
            $this->filesystem->ensureDirectoryExists(resource_path('css'));
            $this->filesystem->ensureDirectoryExists(resource_path('js'));

            info('Installing breeze: breeze:install');
            $this->call('breeze:install', [
                'stack' => 'blade',
                '--no-interaction' => true,
            ]);

            // Remove Breeze's Tailwind-based components that adash replaces with Bootstrap versions
            $this->filesystem->delete([
                resource_path('views/layouts/navigation.blade.php'),
                resource_path('views/components/text-input.blade.php'),
                resource_path('views/components/secondary-button.blade.php'),
                resource_path('views/components/responsive-nav-link.blade.php'),
                resource_path('views/components/primary-button.blade.php'),
                resource_path('views/components/nav-link.blade.php'),
                resource_path('views/components/modal.blade.php'),
                resource_path('views/components/input-label.blade.php'),
                resource_path('views/components/input-error.blade.php'),
                resource_path('views/components/dropdown-link.blade.php'),
                resource_path('views/components/dropdown.blade.php'),
                resource_path('views/components/danger-button.blade.php'),
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

        if (\in_array('default', $this->modules)) {
            $options['--tag'] = 'adash-default';
            $this->publishDefault($options);
        }
        if (\in_array('faqs', $this->modules)) {
            $options['--tag'] = 'adash-faqs';
            $this->publishFaqs($options);
        }
        if (\in_array('pages', $this->modules)) {
            $options['--tag'] = 'adash-pages';
            $this->publishPages($options);
        }
        if (\in_array('testimonials', $this->modules)) {
            $options['--tag'] = 'adash-testimonials';
            $this->publishTestimonials($options);
        }

        info('Adash scaffolding installed successfully.');
    }

    public function migrateDB(): void
    {
        if ($this->migrateFresh) {
            $this->call('migrate:fresh');
            info('Fresh database successfully migrated');
        } else {
            $this->call('migrate');
            info('Database successfully migrated');
        }
        $this->newLine();
    }

    public function seedDB(): void
    {
        if (!$this->seedDatabase) {
            return;
        }

        $this->call('db:seed');
        info('Database successfully seeded');
        $this->newLine();
    }

    public function writeViteResources(): void
    {
        // vite.config.js — three separate entry groups: admin, guest, app
        $this->filesystem->put(base_path('vite.config.js'),
            "import { defineConfig } from 'vite';\n"
            . "import laravel from 'laravel-vite-plugin';\n\n"
            . "export default defineConfig({\n"
            . "    plugins: [\n"
            . "        laravel({\n"
            . "            input: [\n"
            . "                'resources/admin/css/admin.css',\n"
            . "                'resources/admin/js/admin.js',\n"
            . "                'resources/guest/css/guest.css',\n"
            . "                'resources/guest/js/guest.js',\n"
            . "                'resources/app/css/app.css',\n"
            . "                'resources/app/js/app.js',\n"
            . "            ],\n"
            . "            refresh: true,\n"
            . "        }),\n"
            . "    ],\n"
            . "});\n"
        );

        // admin — DataTables only; the admin theme ships its own Bootstrap static assets
        $this->filesystem->ensureDirectoryExists(resource_path('admin/css'));
        $this->filesystem->ensureDirectoryExists(resource_path('admin/js'));
        $this->filesystem->put(resource_path('admin/css/admin.css'),
            "@import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';\n"
            . "@import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';\n"
            . "@import 'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css';\n"
        );
        $this->filesystem->put(resource_path('admin/js/admin.js'),
            "import $ from 'jquery';\n"
            . "window.$ = window.jQuery = $;\n"
            . "import 'laravel-datatables-vite';\n"
            . "import 'datatables.net-bs5';\n"
            . "import 'datatables.net-buttons/js/buttons.colVis.mjs';\n"
            . "import 'datatables.net-buttons/js/buttons.html5.mjs';\n"
            . "import 'datatables.net-buttons/js/buttons.print.mjs';\n"
            . "import 'datatables.net-responsive-bs5';\n"
        );

        // guest — Bootstrap 5 for login/register/forgot-password pages
        $this->filesystem->ensureDirectoryExists(resource_path('guest/css'));
        $this->filesystem->ensureDirectoryExists(resource_path('guest/js'));
        $this->filesystem->put(resource_path('guest/css/guest.css'),
            "@import 'bootstrap/dist/css/bootstrap.min.css';\n"
        );
        $this->filesystem->put(resource_path('guest/js/guest.js'),
            "import $ from 'jquery';\n"
            . "window.$ = window.jQuery = $;\n"
            . "import * as bootstrap from 'bootstrap';\n"
            . "window.bootstrap = bootstrap;\n"
        );

        // app — Bootstrap 5 for authenticated frontend layout
        $this->filesystem->ensureDirectoryExists(resource_path('app/css'));
        $this->filesystem->ensureDirectoryExists(resource_path('app/js'));
        $this->filesystem->put(resource_path('app/css/app.css'),
            "@import 'bootstrap/dist/css/bootstrap.min.css';\n"
        );
        $this->filesystem->put(resource_path('app/js/app.js'),
            "import $ from 'jquery';\n"
            . "window.$ = window.jQuery = $;\n"
            . "import * as bootstrap from 'bootstrap';\n"
            . "window.bootstrap = bootstrap;\n"
        );

        // Remove Breeze's Tailwind entry files and folders so they don't conflict
        $this->filesystem->deleteDirectory(resource_path('css'));
        $this->filesystem->deleteDirectory(resource_path('js'));

        info('Vite entry points written: resources/{admin,guest,app}/{css,js}');
    }

    public function createAdmin(): void
    {
        $admin = User::whereRelation('roles', 'name', 'admin')->first();
        if (!$admin) {
            info('Creating admin user, which will be used to login. Please enter the details.');
            if (PHP_OS_FAMILY === 'Windows') {
                $adminPassword = '123456';
                $data = [
                    'email'             => 'adash@gmail.com',
                    'name'              => 'Admin',
                    'mobile'            => '9876543210',
                    'email_verified_at' => now(),
                    'password'          => $adminPassword,
                    'status'            => true,
                ];
            } else {
                $data = form()
                    ->text(label: 'Name', name: 'name', default: 'Admin', required: true)
                    ->text(label: 'Email', name: 'email', default: 'adash@gmail.com', validate: ['email' => 'required|email|unique:users,email'])
                    ->password(label: 'Password', name: 'password', hint: 'At least 6 characters', validate: ['password' => 'required|min:6'])
                    ->text(label: 'Mobile', name: 'mobile', default: '9876543210', validate: ['mobile' => 'required|min:10'])
                    ->confirm(label: 'Email verified?', name: 'email_verified_at', default: true)
                    ->select(label: 'Status', name: 'status', options: ['1' => 'Active', '0' => 'Inactive'], default: '1')
                    ->submit();

                $adminPassword = $data['password'];
                $data['email_verified_at'] = $data['email_verified_at'] ? now() : null;
            }

            $admin = User::create($data);
            $role = Role::firstOrCreate(['name' => 'admin']);
            $admin->roles()->attach([$role->id]);

            $this->line('    Name: ' . $admin->name);
            $this->line('    Email: ' . $admin->email);
            $this->line('    Password: ' . $adminPassword);
            info('Admin user created successfully.');

            $this->ask('Press Enter to continue?');
        }
    }
}

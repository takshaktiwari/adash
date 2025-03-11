<?php

namespace Takshak\Adash\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
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

    public function handle()
    {
        if ($this->option('modules')) {
            if ($this->option('modules') == 'all') {
                $this->modules = ['faqs', 'pages', 'testimonials', 'default'];
            } else {
                $this->modules = array_map(fn($item) => trim($item), explode(',', $this->option('modules')));
                $this->modules = array_filter($this->modules, function ($item) {
                    return in_array($item, ['faqs', 'pages', 'testimonials', 'default']);
                });
            }
        } else {

            $this->modules = multiselect(
                label: 'Please specify modules you want to install?',
                options: ['default', 'faqs', 'pages', 'testimonials', 'all of above'],
                default: ['all of above'],
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
            : confirm(
                label: 'Do you wish to seed dummy images?',
                default: false
            );


        if ($seedImages) {
            $imagesCount = text(
                label: 'How many dummy images you want to seed?',
                default: 10
            );
            $imagesCount = (int)$imagesCount;

            info('Seeding dummy images: ' . $imagesCount);
            Artisan::call('imager:seed ' . $imagesCount);
            $this->line(Artisan::output());
        }

        $this->askQuestions();
        $this->publishFiles();
        $this->migrateDB();
        $this->createAdmin();
        $this->seedDB();

        info('Setting up vite for datatables');
        Process::run('npm install laravel-datatables-vite datatables.net-bs5 datatables.net-responsive-bs5');
        $this->filesystem->append(resource_path('css/app.css'), "
            @import url('https://fonts.bunny.net/css?family=Nunito');
            @import 'bootstrap-icons/font/bootstrap-icons.css';
            @import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
            @import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';
            @import 'datatables.net-select-bs5/css/select.bootstrap5.css';
            @import 'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css';
        ");
        $this->filesystem->append(resource_path('js/app.js'), "
            import 'laravel-datatables-vite';
            import 'datatables.net-bs5';
            import 'datatables.net-responsive-bs5';
        ");
        Process::run('npm run build');

        $this->call('storage:link');

        $this->info('Adash Setup is successfully installed.');
        $this->info('You will find the login credentials in documentation on github or just check the database seeder');
        $this->info('https://github.com/takshaktiwari/adash');
    }

    public function askQuestions()
    {
        $this->installType = $this->argument('install');
        if ($this->installType != 'fresh') {
            $this->replaceFiles = confirm(
                label: 'Do you wish to replace existing files?',
                default: true
            );

            $this->migrateFresh = confirm(
                label: 'How do you run fresh migration?',
                default: true
            );

            $this->seedDatabase = confirm(
                label: 'Do you wish to seed database?',
                default: true
            );
        }
    }

    public function publishFiles()
    {
        if ($this->installType == 'fresh' || in_array('default', $this->modules)) {
            info('Installing breeze: breeze:install');
            $this->call('breeze:install', [
                'stack' => 'blade'
            ]);

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

        info('Adash scaffolding installed successfully.');
    }

    public function migrateDB()
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

    public function seedDB()
    {
        if (!$this->seedDatabase) {
            return false;
        }

        $this->call('db:seed');
        info('Database successfully seeded');
        $this->newLine();
    }

    public function createAdmin()
    {
        $admin = User::whereRelation('roles', 'name', 'admin')->first();
        if (!$admin) {
            info('Creating admin user, which will be used to login. Please enter the details.');
            $data = form()
                ->text(label: 'Name', name: 'name', default: 'Admin', required: true)
                ->text(label: 'Email', name: 'email', default: 'adash@gmail.com', validate: ['email' => 'required|email|unique:users,email'])
                ->password(label: 'Password', name: 'password', hint: 'At least 6 characters', validate: ['password' => 'required|min:6'])
                ->text(label: 'Mobile', name: 'mobile', default: '9876543210', validate: ['mobile' => 'required|min:10'])
                ->confirm(label: 'Email verified?', name: 'email_verified_at', default: true)
                ->select(label: 'Status', name: 'status', options: [true => 'Active', false => 'Inactive'], default: true)
                ->submit();

            $data['email_verified_at'] = $data['email_verified_at'] ? now() : null;
            $data['password'] = Hash::make($data['password']);

            $admin = User::create($data);
            $role = Role::firstOrCreate(['name' => 'admin']);
            $admin->roles()->attach([$role->id]);

            info('Admin user created successfully.');
        }
    }
}

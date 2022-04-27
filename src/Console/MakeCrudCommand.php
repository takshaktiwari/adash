<?php

namespace Takshak\Adash\Console;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud {controller}
    {--model=}
    {--views=}
    {--requests=}
    {--seeder=}
    {--migration=}';


    protected $description = 'Generate Controller with all resourceful content along with Model and Views';

    protected $str;
    protected $filesystem;

    protected $controllers;
    protected $models;
    protected $views;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem;
        $this->str = new Str;

        $this->controllers = app_path('Http/Controllers/');
        $this->requests = app_path('Http/Requests/');
        $this->models = app_path('Models/');
        $this->views = resource_path('views/');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stub = $this->filesystem->get(__DIR__.'/stubs/CrudController.stub');

        $newController = $this->str->of($this->controllers.$this->argument('controller'))->replace('//', '/')->append('.php');
        $controllerName = $this->str->of($this->argument('controller'))->afterLast('/');
        $this->filesystem->ensureDirectoryExists($this->str->of($newController)->beforeLast('/'));
        $this->filesystem->put($newController, $stub);
        $this->info($this->argument('controller').' is successfully created.');

        $baseController = '';
        if (Str::of($this->argument('controller'))->contains('/')) {
            $baseController = 'use App\Http\Controllers\Controller;';
        }

        $this->filesystem->replaceInFile(
            '{{ BaseController }}',
            $baseController,
            $newController
        );
        $this->filesystem->replaceInFile(
            '{{ ControllerName }}',
            $controllerName,
            $newController
        );

        $namespace = 'App/Http/Controllers';
        if (Str::of($this->argument('controller'))->contains('/')) {
            $folder = Str::of($this->argument('controller'))->beforeLast('/');
            $namespace .= $folder ? '/'.$folder : '';
        }
        $namespace = Str::of($namespace)->replace('/', '\\');

        $this->filesystem->replaceInFile(
            '{{ namespace }}',
            $namespace,
            $newController
        );

        $model = $this->option('model');
        if (!$model) {
            if ($this->confirm('Do you want to generate model.', true)) {
                $model = Str::of($this->argument('controller'))->before('Controller');
                $newModel = $this->ask('`'.$model.'` will be generated. Enter the new name if you want to change or press `Enter`');
                if ($newModel) {
                    $model = $newModel;
                }
            }
        }

        if ($model) {
            $modelName = Str::of($model)->ucfirst()->afterLast('/');
            $model = Str::of($model)->ucfirst();
            $this->call(
                'make:model',
                ['name' => $model]
            );
            $this->info($model.' model is successfully created.');

            // create migration
            $migrationName = $this->option('migration');
            if (!$migrationName) {
                if ($this->confirm('Do you want to create migration?', true)) {
                    $migrationName = Str::of($model)->after('/')->lower()->plural();
                    $newMigrationName = $this->ask('Do you wnat to create migration: `'.$migrationName.'`. Enter new name if you want to change, eg: user');
                    if ($newMigrationName) {
                        $migrationName = $newMigrationName;
                    }
                }
            }

            if ($migrationName) {
                $migrationName = Str::of($migrationName)->lower()->plural()->prepend('create_')->append('_table');
                $this->call(
                    'make:migration',
                    ['name' => $migrationName]
                );
                $this->info($migrationName.' migration is successfully created.');
            }

            $seeder = $this->option('seeder');
            if (!$seeder) {
                if ($this->confirm('Do you want to create seeder?', true)) {
                    $seeder = Str::of($model)->after('/')->append('Seeder');
                    $newSeeder = $this->ask('Do you wnat to create seeder: `'.$seeder.'`. Enter new name if you want to change.');
                    if ($newSeeder) {
                        $seeder = $newSeeder;
                    }
                }
            }

            if ($seeder) {
                $this->call(
                    'make:seed',
                    ['name' => $seeder]
                );
                $this->info($seeder.' seeder is successfully created.');
            }
        } else {
            $model = 'CrudModel';
            $modelName = Str::of($model)->ucfirst()->afterLast('/');
            $this->line('No Model is created, default `'.$modelName.'` model will be used');
        }
        $this->newLine();



        $this->createRequests($model, $newController);

        $useModel = 'App/Models/'.$model;
        $useModel = Str::of($useModel)->replace('/', '\\');
        $this->filesystem->replaceInFile(
            '{{ UseModel }}',
            $useModel,
            $newController
        );
        $this->filesystem->replaceInFile(
            '{{ Model }}',
            $modelName,
            $newController
        );
        $this->filesystem->replaceInFile(
            '{{ model }}',
            lcfirst($modelName),
            $newController
        );
        $this->filesystem->replaceInFile(
            '{{ models }}',
            Str::of($modelName)->camel()->plural(),
            $newController
        );

        $this->createViews($model, $newController);
        $this->setupRouteGroup($model, $newController);
    }

    public function createRequests($model, $newController)
    {
        if (!$this->option('requests')) {
            $generateRequests = $this->confirm('Generate Form Request files.', true);
            if (!$generateRequests) {
                $this->filesystem->replaceInFile(
                    '{{ UseStoreModelRequest }}',
                    'StoreModelRequest',
                    $newController
                );
                $this->filesystem->replaceInFile(
                    '{{ UseUpdateModelRequest }}',
                    'UpdateModelRequest',
                    $newController
                );
                $this->filesystem->replaceInFile(
                    '{{ StoreModelRequest }}',
                    'StoreModelRequest',
                    $newController
                );
                $this->filesystem->replaceInFile(
                    '{{ UpdateModelRequest }}',
                    'UpdateModelRequest',
                    $newController
                );
                return false;
            }
        }

        $modelName = Str::of($model)->afterLast('/');
        $requestParentPath = '';
        if (Str::of($model)->contains('/')) {
            $requestParentPath = Str::of($model)->beforeLast('/')->append('/');
        }

        if ($this->option('requests')) {
            $requestParentPath = Str::of($this->option('requests'))->ucfirst()->append('/');
        }

        $storeRequestName = 'Store'.$modelName.'Request';
        $updateRequestName = 'Update'.$modelName.'Request';

        if (!$this->option('requests')) {
            $this->info($requestParentPath.$storeRequestName.' Request will be created');
            $this->info($requestParentPath.$updateRequestName.' Request will be created');
            $newPath = $this->ask('Base Request Path is `'.($requestParentPath ? $requestParentPath : '/').'`. Enter the new path if you want to change the Request\'s Base Path `'.$requestParentPath.'`');

            if ($newPath) {
                $requestParentPath = $newPath;
            }
        }
        if (!Str::endsWith($requestParentPath, '/')) {
            $requestParentPath = Str::of($requestParentPath)->append('/');
        }
        if ($requestParentPath == '/') {
            $requestParentPath == '';
        }

        $storeRequest = $requestParentPath.$storeRequestName;
        $updateRequest = $requestParentPath.$updateRequestName;

        $this->call('make:request', ["name" => $storeRequest]);
        $this->info($storeRequest.' request is successfully created.');

        $this->call('make:request', ["name" => $updateRequest]);
        $this->info($updateRequest.' request is successfully created.');

        $this->filesystem->replaceInFile(
            '{{ UseStoreModelRequest }}',
            Str::of($storeRequest)->replace('/', '\\')->before('.php'),
            $newController
        );
        $this->filesystem->replaceInFile(
            '{{ UseUpdateModelRequest }}',
            Str::of($updateRequest)->replace('/', '\\')->before('.php'),
            $newController
        );
        $this->filesystem->replaceInFile(
            '{{ StoreModelRequest }}',
            Str::of($storeRequest)->afterLast('/')->before('.php'),
            $newController
        );
        $this->filesystem->replaceInFile(
            '{{ UpdateModelRequest }}',
            Str::of($updateRequest)->afterLast('/')->before('.php'),
            $newController
        );

        return [
            'store' =>  $storeRequest,
            'update' =>  $updateRequest,
        ];
    }

    public function createViews($model, $newController)
    {
        $viewsPath = $this->option('views')
            ?   $this->option('views')
            :   $this->ask('Enter views folder path after resource/views.');

        if (!$viewsPath) {
            $viewsPath = Str::of($model)->lower()->plural();
        }

        $viewPath = Str::of($this->views.$viewsPath)->replace('//', '/')->replace('.', '/');

        $this->filesystem->ensureDirectoryExists($viewPath);
        $newViews = [
            $viewPath.'/index.blade.php',
            $viewPath.'/create.blade.php',
            $viewPath.'/edit.blade.php',
            $viewPath.'/show.blade.php',
        ];

        foreach ($newViews as $view) {
            $view = Str::of($view)->replace('//', '/');

            $content = Str::of($view)
            ->afterLast('/')
            ->before('.blade')
            ->ucfirst()->singular()
            ->append(' view for '.$viewsPath.' folder, Generated by CRUD command.');

            $this->filesystem->put($view, $content);
            $this->info($this->str->of($view)->after(resource_path()).' view successfully created.');
        }

        $this->filesystem->replaceInFile(
            '{{ viewsPath }}',
            $this->str->of($viewsPath)->replace('/', '.'),
            $newController
        );
    }

    public function setupRouteGroup($model, $newController)
    {
        $routeGroup = $this->ask('Enter route group name. eg: {routeGroup}.index, {routeGroup}.show');
        if ($routeGroup == '') {
            $routeGroup = Str::of($model)->lower()->plural();
        }
        $this->filesystem->replaceInFile(
            '{{ routeGroup }}',
            $routeGroup,
            $newController
        );
    }
}

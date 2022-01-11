<?php

namespace Takshak\Adash\Console;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud {controller} {--model=} {--views=} {--requests=}';

    
    protected $description = 'Generate Controller with all resourcefulcontent along with Model and Views';

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


        $this->filesystem->replaceInFile(
            '{{ ControllerName }}', $controllerName, $newController
        );

        $namespace = 'App/Http/Controller';
        if (Str::of($this->argument('controller'))->contains('/')) {
            $folder = \Str::of($this->argument('controller'))->beforeLast('/');
            $namespace .= $folder ? '/'.$folder : '';
        }
        $namespace = Str::of($namespace)->replace('/', '\\');

        $this->filesystem->replaceInFile(
            '{{ namespace }}', $namespace, $newController
        );

        $model = $this->option('model')
            ?   $this->option('model')
            :   $this->ask('Enter the model name.');
        $modelName = Str::of($model)->ucfirst()->afterLast('/');
        $model = Str::of($model)->ucfirst();
        $this->call(
            'make:model', 
            ['name' => $model]
        );
        $this->info($model.' is successfully created.');
        $this->info('No Model is created, default '.$modelName.' model will be used');

        $this->createRequests($model, $newController);
        

        $useModel = 'App/Models/'.$model;
        $useModel = Str::of($useModel)->replace('/', '\\');
        $this->filesystem->replaceInFile(
            '{{ UseModel }}', $useModel, $newController
        );
        $this->filesystem->replaceInFile(
            '{{ Model }}', $modelName, $newController
        );
        $this->filesystem->replaceInFile(
            '{{ model }}', lcfirst($modelName), $newController
        );
        $this->filesystem->replaceInFile(
            '{{ models }}', 
            Str::of($modelName)->camel()->plural(), 
            $newController
        );

        $this->createViews($newController);

        $routeGroup = $this->ask('Enter route group name. eg: {routeGroup}.index, {routeGroup}.show');
        $this->filesystem->replaceInFile(
            '{{ routeGroup }}', $routeGroup, $newController
        );
    }

    public function createRequests($model, $newController)
    {
        if (!$model) {
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

        $requestsPath = $this->requests;
        if (Str::of($model)->contains('/')) {
            $requestsPath .= Str::of($model)->beforeLast('/');
        }

        $modelName = Str::of($model)->afterLast('/');
        $modelParentPath = '';
        if (Str::of($model)->contains('/')) {
            $modelParentPath = Str::of($model)->beforeLast('/')->append('/');
        }

        if ($this->option('requests')) {
            $modelParentPath = Str::of($this->option('requests'))->ucfirst()->append('/');
        }

        $storeRequest = $modelParentPath.'Store'.$modelName.'Request.php';
        $updateRequest = $modelParentPath.'Update'.$modelName.'Request.php';

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
            \Str::of($storeRequest)->afterLast('/')->before('.php'), 
            $newController
        );
        $this->filesystem->replaceInFile(
            '{{ UpdateModelRequest }}', 
            \Str::of($updateRequest)->afterLast('/')->before('.php'), 
            $newController
        );

        return [
            'store' =>  $storeRequest,
            'update' =>  $updateRequest,
        ];
    }

    public function createViews($newController)
    {
        $viewsPath = $this->option('views')
            ?   $this->option('views')
            :   $this->ask('Enter views folder path after resource/views.');

        $viewPath = \Str::of($this->views.$viewsPath)->replace('//', '/');
        $this->filesystem->ensureDirectoryExists($viewPath);
        $newsViews = [
            $viewPath.'/index.blade.php',
            $viewPath.'/create.blade.php',
            $viewPath.'/edit.blade.php',
            $viewPath.'/show.blade.php',
        ];

        foreach ($newsViews as $view) {
            $content = \Str::of($view)
            ->afterLast('/')
            ->before('.blade')
            ->ucfirst()->singular()
            ->append(' view for '.$viewsPath.' folder, Generated by CRUD command.');

            $this->filesystem->put(
                $view, 
                $content
            );

            $this->info($this->str->of($view)->after(resource_path()).' view successfully created.');
        }

        $this->filesystem->replaceInFile(
            '{{ viewsPath }}', $this->str->of($viewsPath)->replace('/', '.'), $newController
        );
    }

}

<?php

namespace Takshak\Adash\Console;

use Illuminate\Console\Command;
use Takshak\Adash\Models\Setting;

class SettingsCommand extends Command
{
    protected $signature = 'adash:settings {action?} {--search=}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        if ($this->argument('action') == 'create') {
            $this->createSetting();
            cache()->forget('settings');
            exit;
        }
        if ($this->argument('action') == 'update') {
            $this->updateSetting();
            cache()->forget('settings');
            exit;
        }
        if ($this->argument('action') == 'flush') {
            cache()->forget('settings');
            exit;
        }

        $settings = Setting::query()
            ->when($this->option('search'), function ($query) {
                $query->where('title', 'LIKE', '%' . $this->option('search') . '%');
                $query->orWhere('setting_key', 'LIKE', '%' . $this->option('search') . '%');
                $query->orWhere('setting_value', 'LIKE', '%' . $this->option('search') . '%');
                $query->orWhere('remarks', 'LIKE', '%' . $this->option('search') . '%');
            })
            ->get();

        foreach ($settings as $setting) {
            $this->info($setting->setting_key . ' -> ' . $setting->setting_value);
            $this->line($setting->title . ': ' . $setting->remarks);
            $this->newLine();
        }
    }

    public function createSetting()
    {
        $title = $this->ask('Enter the title / name of the setting.');
        if (!$title) {
            $this->error('Please provide an input. Starting again ...');
            $this->handle();
        }

        $setting_key = $this->ask('What is the key of the setting by which it will be called?');
        if (!$setting_key) {
            $this->error('Please provide an input. Starting again ...');
            $this->handle();
        }
        $setting_key = str()->of($setting_key)->slug('_');

        $setting_value = $this->ask('Enter the setting value.');
        if (!$setting_value) {
            $this->error('Please provide an input. Starting again ...');
            $this->handle();
        }

        $protected = $this->ask('Is this key protected / required ?');
        $protected = (bool)$protected;

        $remarks = $this->ask('[optional] Describe some more about the setting.');

        $setting = Setting::updateOrCreate(
            [
                'title' => $title,
                'setting_key' => $setting_key,
            ],
            [
                'setting_value' => $setting_value,
                'protected' => $protected,
                'remarks' => $remarks,
            ]
        );

        $this->displaySetting($setting);
        $this->info('Settings has been updated.');
    }

    public function updateSetting()
    {
        $idOrKey = $this->ask('Enter setting id or key name.');
        if (!$idOrKey) {
            $this->error('Please provide an input. Starting again ...');
            $this->handle();
        }

        $setting = Setting::query()
            ->where('id', $idOrKey)
            ->orWhere('setting_key', $idOrKey)
            ->first();
        if (!$setting) {
            $this->error('No setting found with this given id or key name.');
            $this->handle();
        }

        $setting_value = $this->ask('Enter the setting value.');
        if (!$setting_value) {
            $this->error('Please provide an input. Starting again ...');
            $this->handle();
        }

        $setting->update(['setting_value' => $setting_value]);
        $this->displaySetting($setting);
        $this->info('Settings has been updated.');
    }

    public function displaySetting($setting)
    {
        $this->table(
            ['--', '--'],
            [
                ['id', $setting->id],
                ['title', $setting->title],
                ['setting_key', $setting->setting_key],
                ['setting_value', $setting->setting_value],
                ['protected', $setting->protected],
                ['remarks', $setting->remarks],
            ]
        );
    }
}

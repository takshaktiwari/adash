<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            [
                'title' => 'Site Name',
                'setting_key' => 'site_name'
            ],
            [
                'setting_value' => 'Adash Technologies',
                'protected' => true,
                'remarks' => 'Full name of the site'
            ]
        );

        Setting::updateOrCreate(
            [
                'title' => 'Site short name',
                'setting_key' => 'site_short_name'
            ],
            [
                'setting_value' => 'AD',
                'protected' => true,
                'remarks' => 'Short name of the site, Possibly 2, 4 or some characters'
            ]
        );


        Setting::updateOrCreate(
            [
                'title' => 'Logo full',
                'setting_key' => 'logo_full'
            ],
            [
                'setting_value' => url('imgr/placeholder?w=300&h=120&text=Adash&text_size=72&background=2838ff&text_color=fff'),
                'protected' => true,
                'remarks' => 'Full or large size logo'
            ]
        );

        Setting::updateOrCreate(
            [
                'title' => 'Logo short',
                'setting_key' => 'logo_short'
            ],
            [
                'setting_value' => url('imgr/placeholder?w=120&h=120&text=AD&text_size=72&background=2838ff&text_color=fff'),
                'protected' => true,
                'remarks' => 'Small size logo'
            ]
        );

        Setting::updateOrCreate(
            [
                'title' => 'Favicon',
                'setting_key' => 'favicon'
            ],
            [
                'setting_value' => url('imgr/placeholder?w=60&h=60&text=AD&text_size=36&background=2838ff&text_color=fff'),
                'protected' => true,
                'remarks' => 'favicon'
            ]
        );

        Setting::updateOrCreate(
            [
                'title' => 'Primary email',
                'setting_key' => 'primary_email'
            ],
            [
                'setting_value' => 'adash@gmail.com',
                'protected' => true,
                'remarks' => 'Default email on which query and other details will be sent.'
            ]
        );
    }
}

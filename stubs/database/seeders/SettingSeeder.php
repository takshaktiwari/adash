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

        Setting::updateOrCreate(
            [
                'title' => 'Theme layout',
                'setting_key' => 'theme_layout'
            ],
            [
                'setting_value' => 'layout_default',
                'protected' => true,
                'remarks' => 'Admin panel layout types. Possible values are: layout_default, layout_rounded'
            ]
        );

        Setting::updateOrCreate(
            [
                'title' => 'Theme colors',
                'setting_key' => 'theme_colors'
            ],
            [
                'setting_value' => json_encode([
                    'primary' => [
                        'color' => '#333547',
                        'remarks' => 'Primary / Sidebar color'
                    ],
                    'primary2' => [
                        'color' => '#383b4e',
                        'remarks' => 'Primary2 / Sidebar hover color'
                    ],
                    'secondary' => [
                        'color' => '#f8f8fa',
                        'remarks' => 'Secondary / Site background'
                    ],
                    'text-color' => [
                        'color' => '#e6e6e6',
                        'remarks' => 'Text color'
                    ],
                    'text-color2' => [
                        'color' => '#b4c9de',
                        'remarks' => 'Text color'
                    ],
                    'text-color3' => [
                        'color' => '#3b3b3b',
                        'remarks' => 'Text color'
                    ],
                    'text-color4' => [
                        'color' => '#6c757d',
                        'remarks' => 'Text color'
                    ],
                    'header-bg' => [
                        'color' => '#ffffff',
                        'remarks' => 'Header background'
                    ],
                    'footer-bg' => [
                        'color' => '#ffffff',
                        'remarks' => 'Footer background'
                    ],
                    'card-bg' => [
                        'color' => '#ffffff',
                        'remarks' => 'Content card background'
                    ],
                    'card-footer-bg' => [
                        'color' => '#e9ecef',
                        'remarks' => 'Content card footer background'
                    ]
                ]),
                'protected' => true,
                'remarks' => 'Change theme colors, sidebar, header, footer and text colors. Only applicable on light theme layout.'
            ]
        );
    }
}

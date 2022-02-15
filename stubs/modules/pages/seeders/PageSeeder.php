<?php

namespace Database\Seeders;

use Storage;
use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        Storage::disk('public')->deleteDirectory('pages');
        Page::truncate();
        Page::factory(5)->create();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Takshak\Adash\Models\Page;

class PageSeeder extends Seeder
{
    public function run()
    {
        Storage::disk('public')->deleteDirectory('pages');
        Page::truncate();
        Page::factory(5)->create();
    }
}

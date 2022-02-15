<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    
    public function run()
    {
        Faq::truncate();
        Faq::factory(15)->create();
    }
}

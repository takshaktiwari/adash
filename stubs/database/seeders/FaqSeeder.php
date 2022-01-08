<?php

namespace Database\Seeders;

use App\Models\Faq;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    
    public function run(Faker $faker)
    {
        for ($i=0; $i < 30; $i++) { 
            $faq = new Faq;
            $faq->question  =   $faker->realText(rand(50, 150));
            $faq->pref      =   $i;
            $faq->answer    =   $faker->realText(rand(200, 500));
            $faq->status    =   true;
            $faq->save();
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();
        
        Category::create(['name' => '卸売A']);
        Category::create(['name' => '卸売B']);
        Category::create(['name' => '卸売C']);
    }
}
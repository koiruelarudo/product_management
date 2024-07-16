<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $A_wholesale = Category::where('name', '卸売A')->first();
        $B_wholesale = Category::where('name', '卸売B')->first();
        $C_wholesale = Category::where('name', '卸売C')->first();

        Product::create([
            'name' => 'ドライバー',
            'price' => 3000,
            'description' => '一箱8個入',
            'category_id' => $A_wholesale->id,
        ]);

        Product::create([
            'name' => 'レンチ',
            'price' => 800,
            'description' => '',
            'category_id' => $B_wholesale->id,
        ]);

        Product::create([
            'name' => 'ワッシャー',
            'price' => 8,
            'description' => '6mm',
            'category_id' => $C_wholesale->id,
        ]);
    }
}

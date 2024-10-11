<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::query()->pluck('id')->toArray();

        Product::factory(10)->create()->each(function ($product) use ($categories) {
            $product->category_id = $categories[array_rand($categories)];
        });
    }
}

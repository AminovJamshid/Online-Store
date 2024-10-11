<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
        ]);

//
//        User::factory()
//            ->count(50)
//            ->create()
//            ->each(function ($user) {
////                $user->cart()->create();
//
//                Order::factory()->count(rand(0, 5))->for($user)->create();
//            });
//


//        Cart::factory()->count(5)->create();
    }
}

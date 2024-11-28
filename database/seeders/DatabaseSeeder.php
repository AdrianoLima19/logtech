<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->admin()->create();
        User::factory(25)->randAdmin()->create();
        User::factory(25)->create();

        User::create([
            'name' => 'John Smith',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        Brand::factory(10)->create();

        $categories = Category::factory(50)->create();

        Product::factory(100)->create()->each(function ($product) use ($categories) {
            $product->categories()->attach(
                $categories->random(rand(0, 3))->pluck('id')->toArray()
            );
        });
    }
}

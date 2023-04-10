<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $product = Product::query()->create([
                'title' => fake()->name(),
                'name' => fake()->name(),
                'user_id' => random_int(1, 10),
                'description' => fake()->text(500),
                'seo_description' => fake()->text(500),
                'view_count' => random_int(1, 40),
                'status' => 1,
            ]);
            $product->categories()->sync(random_int(1, 10));
        }
    }
}

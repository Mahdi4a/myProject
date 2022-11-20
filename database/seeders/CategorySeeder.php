<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
            Category::query()->create([
                'user_id' => random_int(1, 10),
                'name' => fake()->name(),
                'description' => fake()->text(500),
                'title' => fake()->name(),
                'seo_description' => fake()->text(500),
                'category_id' => $i < 5 ? null : ($i - 4),
            ]);
        }
    }
}

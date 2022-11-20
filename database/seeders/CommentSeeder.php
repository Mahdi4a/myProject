<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $products = Product::query()->get();
        foreach ($products as $item) {
            $item->comments()->create([
                'user_id' => random_int(1, 10),
                'approved' => random_int(0, 1),
                'comment' => fake()->text(500),
            ]);
        }
    }
}

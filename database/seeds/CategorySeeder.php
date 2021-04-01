<?php

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range(1, 5) as $index) {

            $category = $faker->unique()->name;

            Category::create([
                "name" => $category,
                "slug" => Str::slug($category, "-"),
                "status" => rand(0, 1)
            ]);
        }
    }
}

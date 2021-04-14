<?php

use App\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->getRandomStatus();

        $faker = Faker\Factory::create();

        foreach (range(1, 30) as $index) {

            $title = $faker->sentence;

            Post::create([
                "user_id" => rand(1, 20),
                "category_id" => rand(1, 5),
                "title" => $faker->sentence,
                "slug" => Str::slug($title, "-"),
                "content" => $faker->paragraph,
                "thumbnail" => $faker->imageUrl,
                "status" => $this->getRandomStatus()
            ]);
        }
    }

    public function getRandomStatus()
    {
        $statuses = array('draft', 'published');
        return $statuses[array_rand($statuses)];
    }
}

<?php

use App\Post;
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

        foreach (range(1, 100) as $index) {

            Post::create([
                "user_id" => rand(1, 20),
                "category_id" => rand(1, 5),
                "title" => $faker->sentence,
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

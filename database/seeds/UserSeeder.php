<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->defaultUser();

        $faker = Faker\Factory::create();

        foreach (range(1, 20) as $index) {
            User::create([
                "name" => $faker->name,
                "email" => $faker->unique()->email,
                "password" => bcrypt($faker->password)
            ]);
        }
    }

    public function defaultUser()
    {
        User::create([
            "name" => "sohan",
            "email" => "zohirulislam1416@gmail.com",
            "password" => bcrypt("01858220225")
        ]);
    }
}

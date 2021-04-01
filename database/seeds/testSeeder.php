<?php

use Illuminate\Database\Seeder;
use App\Models\Test as Test;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'id' => 1,
                'name' => 'My Test 1'
            ],
            [
                'id' => 2,
                'name' => 'My Test 2'
            ],
        ];

        foreach ($rows as $row) {
            $exists = Test::all()->where('id', $row['id'])->first();

            if ($exists) {
                $exists->update($row);

                continue;
            }

            Test::create($row);
        }
    }
}

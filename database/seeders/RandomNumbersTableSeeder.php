<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RandomNumber;

class RandomNumbersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RandomNumber::create(['number' => 12345]);
        RandomNumber::create(['number' => 67890]);
    }
}

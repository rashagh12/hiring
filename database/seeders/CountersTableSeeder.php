<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Counter;

class CountersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Counter::create(['name' => 'Page Views', 'count' => 1000]);
        Counter::create(['name' => 'Job Applications', 'count' => 200]);
    }
}

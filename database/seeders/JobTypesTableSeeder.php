<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobType::create(['name' => 'Full-time']);
        JobType::create(['name' => 'Part-time']);
        JobType::create(['name' => 'Contract']);
    }
}

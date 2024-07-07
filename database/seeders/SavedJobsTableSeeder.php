<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SavedJob;

class SavedJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SavedJob::create([
            'user_id' => 1,
            'job_id' => 1,
        ]);
    }
}

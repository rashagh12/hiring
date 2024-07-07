<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobApplication;

class JobApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobApplication::create([
            'job_id' => 1,
            'user_id' => 1,
            'cover_letter' => 'I am very interested in this position.',
        ]);
    }
}

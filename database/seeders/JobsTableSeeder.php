<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobsTableSeeder extends Seeder
{
    public function run()
    {
        Job::create([
            'title' => 'Software Developer',
            'description' => 'Develop and maintain web applications.',
            'category_id' => 1,
            'job_type_id' => 1,
            'user_id' => 1,
            'vacancy' => 5,
            'location' => 'San Francisco, CA',
            'salary' => 120000.00,
            'company_name' => 'Tech Corp',
            'benefits' => 'Health insurance, Paid time off, 401(k)',
            'responsibility' => 'Develop and maintain web applications.',
            'qualifications' => 'Bachelor\'s degree in Computer Science or related field.',
            'keywords' => 'PHP, Laravel, JavaScript',
            'experience' => '3+ years of experience in software development.',
            'company_location' => 'San Francisco, CA',
            'status' => 1,
            'isFeatured' => 1,
        ]);

        Job::create([
            'title' => 'Data Analyst',
            'description' => 'Analyze data to provide business insights.',
            'category_id' => 3,
            'job_type_id' => 2,
            'user_id' => 1,
            'vacancy' => 3,
            'location' => 'New York, NY',
            'salary' => 80000.00,
            'company_name' => 'Data Insights Inc.',
            'benefits' => 'Health insurance, Remote work options, Gym membership',
            'responsibility' => 'Analyze data to provide business insights.',
            'qualifications' => 'Bachelor\'s degree in Statistics or related field.',
            'keywords' => 'Data Analysis, SQL, Python',
            'experience' => '2+ years of experience in data analysis.',
            'company_location' => 'New York, NY',
            'status' => 1,
            'isFeatured' => 0,
        ]);
    }
}

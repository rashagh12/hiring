<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed roles
        DB::table('roles')->insert([['name' => 'admin', 'created_at' => now(), 'updated_at' => now()], ['name' => 'employer', 'created_at' => now(), 'updated_at' => now()], ['name' => 'seeker', 'created_at' => now(), 'updated_at' => now()],]);

        // Seed users
        DB::table('users')->insert([['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'profile_picture' => null, 'phone' => '111-111-1111', 'address' => '123 Admin St', 'birth_date' => '1980-01-01', 'age' => 44, 'marital_status' => 'single', 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()], ['name' => 'Employer User', 'email' => 'employer@example.com', 'password' => Hash::make('password'), 'profile_picture' => null, 'phone' => '222-222-2222', 'address' => '456 Employer Rd', 'birth_date' => '1985-02-02', 'age' => 39, 'marital_status' => 'married', 'role_id' => 2, 'created_at' => now(), 'updated_at' => now()], ['name' => 'Seeker User', 'email' => 'seeker@example.com', 'password' => Hash::make('password'), 'profile_picture' => null, 'phone' => '333-333-3333', 'address' => '789 Seeker Ave', 'birth_date' => '1990-03-03', 'age' => 34, 'marital_status' => 'single', 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],]);

        // Seed companies
        DB::table('companies')->insert([['name' => 'Tech Solutions', 'email' => 'info@techsolutions.com', 'phone' => '123-456-7890', 'address' => '123 Tech Lane', 'website' => 'https://techsolutions.com', 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()], ['name' => 'Creative Designs', 'email' => 'contact@creativedesigns.com', 'phone' => '987-654-3210', 'address' => '456 Design Blvd', 'website' => 'https://creativedesigns.com', 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],]);

        // Seed skills
        DB::table('skills')->insert([['name' => 'PHP', 'created_at' => now(), 'updated_at' => now()], ['name' => 'Laravel', 'created_at' => now(), 'updated_at' => now()], ['name' => 'JavaScript', 'created_at' => now(), 'updated_at' => now()], ['name' => 'Adobe Photoshop', 'created_at' => now(), 'updated_at' => now()], ['name' => 'SQL', 'created_at' => now(), 'updated_at' => now()], ['name' => 'SEO', 'created_at' => now(), 'updated_at' => now()],]);

        // Seed categories
        DB::table('categories')->insert([['name' => 'Technology', 'created_at' => now(), 'updated_at' => now()], ['name' => 'Design', 'created_at' => now(), 'updated_at' => now()], ['name' => 'Marketing', 'created_at' => now(), 'updated_at' => now()], ['name' => 'Finance', 'created_at' => now(), 'updated_at' => now()],]);

        // Seed jobs
        DB::table('jobs')->insert([['title' => 'Software Engineer', 'description' => 'Develop and maintain web applications.', 'experience' => '3-5 years', 'benefits' => 'Health insurance, 401(k), Paid time off', 'responsibilities' => 'Write clean, scalable code, Collaborate with cross-functional teams', 'keywords' => 'PHP, Laravel, JavaScript', 'is_featured' => true, 'working_time' => 'full-time', 'vacancies' => 3, 'salary' => '70000', 'company_id' => 1, 'category_id' => 1, // Technology
            'status' => 'approved', 'created_at' => now(), 'updated_at' => now(),], ['title' => 'Graphic Designer', 'description' => 'Design and create graphics for marketing materials.', 'experience' => '2-4 years', 'benefits' => 'Health insurance, Remote work option', 'responsibilities' => 'Create visual elements, Work with marketing team', 'keywords' => 'Adobe Photoshop, Illustrator, Creativity', 'is_featured' => false, 'working_time' => 'part-time', 'vacancies' => 2, 'salary' => '40000', 'company_id' => 2, 'category_id' => 2, // Design
            'status' => 'approved', 'created_at' => now(), 'updated_at' => now(),], ['title' => 'Data Analyst', 'description' => 'Analyze data and generate reports for business insights.', 'experience' => '1-3 years', 'benefits' => 'Health insurance, Flexible hours', 'responsibilities' => 'Analyze data, Generate reports', 'keywords' => 'SQL, Excel, Data Visualization', 'is_featured' => false, 'working_time' => 'remote', 'vacancies' => 1, 'salary' => '60000', 'company_id' => 1, 'category_id' => 4, // Finance
            'status' => 'approved', 'created_at' => now(), 'updated_at' => now(),], ['title' => 'Marketing Manager', 'description' => 'Plan and execute marketing strategies to increase brand awareness.', 'experience' => '5-7 years', 'benefits' => 'Health insurance, 401(k), Paid time off', 'responsibilities' => 'Develop marketing strategies, Lead marketing team', 'keywords' => 'SEO, SEM, Digital Marketing', 'is_featured' => true, 'working_time' => 'full-time', 'vacancies' => 1, 'salary' => '90000', 'company_id' => 2, 'category_id' => 3, // Marketing
            'status' => 'approved', 'created_at' => now(), 'updated_at' => now(),],]);

        // Seed user skills
        DB::table('user_skills')->insert([['user_id' => 3, 'skill_id' => 1, 'created_at' => now(), 'updated_at' => now()], ['user_id' => 3, 'skill_id' => 2, 'created_at' => now(), 'updated_at' => now()], ['user_id' => 3, 'skill_id' => 3, 'created_at' => now(), 'updated_at' => now()],]);

        // Seed job skills
        DB::table('job_skills')->insert([['job_id' => 1, 'skill_id' => 1, 'created_at' => now(), 'updated_at' => now()], ['job_id' => 1, 'skill_id' => 2, 'created_at' => now(), 'updated_at' => now()], ['job_id' => 1, 'skill_id' => 3, 'created_at' => now(), 'updated_at' => now()], ['job_id' => 2, 'skill_id' => 4, 'created_at' => now(), 'updated_at' => now()], ['job_id' => 3, 'skill_id' => 5, 'created_at' => now(), 'updated_at' => now()], ['job_id' => 4, 'skill_id' => 6, 'created_at' => now(), 'updated_at' => now()],]);

        // Seed saved jobs
        DB::table('saved_jobs')->insert([['user_id' => 3, 'job_id' => 1, 'created_at' => now(), 'updated_at' => now()], ['user_id' => 3, 'job_id' => 2, 'created_at' => now(), 'updated_at' => now()],]);
    }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            MaritalStatusTableSeeder::class,
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            JobTypesTableSeeder::class,
            JobsTableSeeder::class,
            SavedJobsTableSeeder::class,
            CountersTableSeeder::class,
            JobApplicationsTableSeeder::class,
            RandomNumbersTableSeeder::class,
        ]);
    }
}

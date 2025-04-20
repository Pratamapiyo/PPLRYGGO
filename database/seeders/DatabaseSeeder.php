<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the RoleSeeder first to create roles
        $this->call(RoleSeeder::class);

        // Call the UserSeeder to create users and assign roles
        $this->call(UserSeeder::class);

        // Call the CategoriesSeeder to create categories
        $this->call(CategoriesSeeder::class);

        // Call the TagsSeeder to create tags
        $this->call(TagsSeeder::class);

        // Call the NewsSeeder to create news
        $this->call(NewsSeeder::class);
        $this->call([
            VendorSeeder::class,
        ]);
    }
}
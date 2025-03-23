<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan kategori dummy
        Category::create([
            'name' => 'Lifestyle',
            'slug' => 'lifestyle',
        ]);

        Category::create([
            'name' => 'Donation',
            'slug' => 'donation',
        ]);

        Category::create([
            'name' => 'Clothing Donation',
            'slug' => 'clothing-donation',
        ]);
    }
}

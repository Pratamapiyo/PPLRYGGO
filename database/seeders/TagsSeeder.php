<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan tag dummy
        Tag::create([
            'name' => 'Donation',
            'slug' => 'donation',
        ]);

        Tag::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
        ]);

        Tag::create([
            'name' => 'Food',
            'slug' => 'food',
        ]);
    }
}

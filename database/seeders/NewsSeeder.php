<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Category;
use App\Models\Tag;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan berita dummy
        $news1 = News::create([
            'title' => 'Clothing Donation to Urban Area',
            'slug' => 'clothing-donation-to-urban-area',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed leo nisl, posuere at molestie ac, suscipit auctor mauris.',
            'image' => 'https://via.placeholder.com/600x400?text=Clothing+Donation', // Placeholder image
            'published_at' => now(),
            'author_id' => 1, // Asumsikan user dengan ID 1 adalah admin
        ]);

        // Menambahkan kategori untuk berita ini
        $news1->categories()->attach(Category::where('slug', 'clothing-donation')->first());

        // Menambahkan tag untuk berita ini
        $news1->tags()->attach(Tag::where('slug', 'clothing')->first());
        $news1->tags()->attach(Tag::where('slug', 'donation')->first());

        // Menambahkan berita lainnya (misalnya)
        $news2 = News::create([
            'title' => 'Food Donation in the Community',
            'slug' => 'food-donation-in-the-community',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis metus elementum, tempor risus vel, condimentum orci.',
            'image' => 'https://via.placeholder.com/600x400?text=Food+Donation', // Placeholder image
            'published_at' => now(),
            'author_id' => 1, // Asumsikan user dengan ID 1 adalah admin
        ]);

        // Menambahkan kategori untuk berita ini
        $news2->categories()->attach(Category::where('slug', 'donation')->first());

        // Menambahkan tag untuk berita ini
        $news2->tags()->attach(Tag::where('slug', 'food')->first());
        $news2->tags()->attach(Tag::where('slug', 'donation')->first());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
        'title', 
        'slug', 
        'body', 
        'image', 
        'published_at', 
        'author_id'
    ];

    /**
     * Cast attributes to specific types.
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Define the relationship between News and Categories.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'news_category', 'news_id', 'category_id');
    }

    /**
     * Define the relationship between News and Tags.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tag', 'news_id', 'tag_id');
    }

    /**
     * Define the relationship between News and its Author (User).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

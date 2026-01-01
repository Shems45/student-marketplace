<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price_cents',
        'image_path',
        'is_sold',
        'is_reserved',
        'is_featured',
        'location_city',
        'location_zip',
        'lat',
        'lng',
    ];

    protected function casts(): array
    {
        return [
            'is_sold' => 'boolean',
            'is_reserved' => 'boolean',
            'is_featured' => 'boolean',
            'price_cents' => 'integer',
            'lat' => 'float',
            'lng' => 'float',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
}

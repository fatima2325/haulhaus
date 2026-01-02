<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category', // Foreign key (slug)
        'price',
        'image',
        'description',
        'reviews',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'reviews' => 'array', // Keep for backward compatibility with old JSON reviews
    ];

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Alias for backward compatibility
     */
    public function productReviews()
    {
        return $this->reviews();
    }

    /**
     * Get the category that owns the product.
     */
    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category', 'slug');
    }
}




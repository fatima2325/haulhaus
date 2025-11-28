<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
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
}




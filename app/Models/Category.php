<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    /**
     * Get the products for the category.
     * Since products use a string 'category' field matching the slug, we query directly.
     * Note: This is not a true Eloquent relationship, but works for our use case.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'slug');
    }

    /**
     * Legacy method wrapper
     */
    public function getProducts()
    {
        return $this->products;
    }
}


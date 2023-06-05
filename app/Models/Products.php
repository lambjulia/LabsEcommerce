<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'name', 'description', 'price', 'category', 'views'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function purchases()
    {
        return $this->hasMany(ClientPurchases::class);
    }

    public function review()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function favorite()
    {
        return $this->hasMany(ClientFavorites::class);
    }
}

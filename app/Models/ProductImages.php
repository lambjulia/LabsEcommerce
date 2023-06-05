<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    use HasFactory;

    protected $fillable = [
         'image', 'path', 'products_id'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class);
    }
}

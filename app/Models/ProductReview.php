<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'products_id', 'comment', 'note'
   ];

   public function product()
   {
       return $this->belongsTo(Products::class);
   }

   public function client()
   {
       return $this->belongsTo(Client::class);
   }
}

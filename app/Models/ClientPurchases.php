<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPurchases extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'products_id', 'seller_id'
   ];

   public function product()
   {
       return $this->belongsTo(Products::class);
   }

   public function client()
   {
       return $this->belongsTo(Client::class);
   }

   public function seller()
   {
       return $this->belongsTo(Seller::class);
   }
}

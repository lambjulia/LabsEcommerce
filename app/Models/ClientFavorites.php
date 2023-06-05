<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFavorites extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'products_id'
   ];

   public function products()
   {
       return $this->belongsTo(Products::class);
   }

   public function client()
   {
       return $this->belongsTo(Client::class);
   }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Seller;
use Illuminate\Support\Facades\Http;

class ProductsSeeder extends Seeder
{
    
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $response = Http::get('https://dummyjson.com/products');
        $products = $response->json();
        $sellerIds = Seller::pluck('id')->toArray();
        // dd($products);
        foreach ($products['products'] as $product) {
            Products::create([
                'id' => $product['id'],
                'seller_id' => $faker->randomElement($sellerIds),
                'name' => $product['title'],
                'description' => $product['description'],
                'price' => $product['price'],
                'category' => $product['category'],

            ]); 
        }

        $this->call(ProductImagesSeeder::class);
      
    }
}

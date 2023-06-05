<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Products;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $response = Http::get('https://dummyjson.com/products');
        $data = $response->json();

        foreach ($data['products'] as $product) {
            $images = $product['images'];

            $product = Products::where('id', $product['id'])->first();

            if ($product) {
                $imagesCount = min(count($images), 3);

                for ($i = 0; $i < $imagesCount; $i++) {
                    $imageUrl = $images[$i];

                    $response = $client->get($imageUrl);
                    
                    $imageData = $response->getBody()->getContents();
            
                    $fileName = uniqid() . '.jpg';
                    $imagePath = 'images/' . $fileName;
                    $path = 'storage/images/' . $fileName;
                    Storage::disk('public')->put($imagePath, $imageData);
                    ProductImages::create([
                        'products_id' => $product['id'],
                        'image' => $imageUrl,
                        'path' => $path,
                    ]);
                }

                }
            }
        }
    }


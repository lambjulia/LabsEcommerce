<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seller;
use App\Models\User;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {

            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $faker->password,
                'role' => 'seller',
            ]);

            Seller::create([
                'user_id' => $user->id,
                'credit' => 0,
                'status' => 'approved',
            ]);
        }
    }
}

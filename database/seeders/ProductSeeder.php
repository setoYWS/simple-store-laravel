<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categoryIDs = DB::table('category_product')->pluck('id');
        
        Product::create([
            'name' => 'meja',
            'price' => 10000,
            'image' => '/assets/image.jpg',
            'product_category_id' => $faker->randomElement($categoryIDs)
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/products.csv');
        $csvData = array_map('str_getcsv', file($path));
        $products = [];
        foreach ($csvData as $row) {
            $products[] = [
                'id' => $row[0],
                'category_id' => (int)$row[1],
                'code' => $row[2],
                'name' => $row[3],
                'slug' => $row[4],
                'description' => $row[5],
                'price' => (int)$row[6],
                'discount_price' => (int)$row[7],
                'stock_quantity' => (int)$row[8],
                'image' => '/customer/images/product-05.jpg',
                'image_detail_2' => '/customer/images/product-05.jpg',
                'image_detail_1' => '/customer/images/product-05.jpg',
                'image_detail_3' => '/customer/images/product-05.jpg',
                'color' => $row[9],
                'material' => $row[10],
                'style' => $row[11],
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('products')->insert($products);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Balo phoi hoa tiet caro',
            'price' => 345000,
            'des' => 'Heads up! These parameters hold sensitive data. To keep this data secure while working in a collaborative environment, we recommend using variables',
            'quantity' => 100,
            'image' => 'img/product/product-1.jpg',
            'category_id' => 2
        ]);

        DB::table('products')->insert([
            'name' => 'Balo phoi hoa tiet caro',
            'price' => 345000,
            'des' => 'Heads up! These parameters hold sensitive data. To keep this data secure while working in a collaborative environment, we recommend using variables',
            'quantity' => 50,
            'image' => 'img/product/product-2.jpg',
            'category_id' => 2
        ]);

        DB::table('products')->insert([
            'name' => 'Tui xach tay phoi vai Tweed',
            'price' => 345000,
            'des' => 'Heads up! These parameters hold sensitive data. To keep this data secure while working in a collaborative environment, we recommend using variables',
            'quantity' => 100,
            'image' => 'img/product/product-3.jpg',
            'category_id' => 4
        ]);

        DB::table('products')->insert([
            'name' => 'Tui xach tay phoi vai Tweed',
            'price' => 345000,
            'des' => 'Heads up! These parameters hold sensitive data. To keep this data secure while working in a collaborative environment, we recommend using variables',
            'quantity' => 100,
            'image' => 'img/product/product-4.jpg',
            'category_id' => 4
        ]);

        DB::table('products')->insert([
            'name' => 'Tui deo cheo nap gap',
            'price' => 200000,
            'des' => 'Heads up! These parameters hold sensitive data. To keep this data secure while working in a collaborative environment, we recommend using variables',
            'quantity' => 50,
            'image' => 'img/product/product-5.jpg',
            'category_id' => 3
        ]);
    }
}

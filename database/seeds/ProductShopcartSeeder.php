<?php

use Illuminate\Database\Seeder;

class ProductShopcartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_shopcarts')->insert([
            'product_id' => 1,
            'shopcart_id' => 1,
            'quantity' => 5
        ]);
        DB::table('product_shopcarts')->insert([
            'product_id' => 2,
            'shopcart_id' => 1,
            'quantity' => 5
        ]);
        DB::table('product_shopcarts')->insert([
            'product_id' => 3,
            'shopcart_id' => 1,
            'quantity' => 3
        ]);
    }
}

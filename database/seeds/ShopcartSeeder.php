<?php

use Illuminate\Database\Seeder;

class ShopcartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shopcarts')->insert([
            'user_id' => 1,
            'status' => 0
        ]);
    }
}

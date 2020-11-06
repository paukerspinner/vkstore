<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'phone' => 89214366553,
            'name' => 'Xuan Canh Pham',
            'email' => 'xcp@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);
    }
}

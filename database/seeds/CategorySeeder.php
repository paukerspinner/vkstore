<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'label' => 'Tui xach'
        ]);

        DB::table('categories')->insert([
            'label' => 'Balo'
        ]);

        DB::table('categories')->insert([
            'label' => 'Tui deo cheo',
            'parent_id' => 1
        ]);

        DB::table('categories')->insert([
            'label' => 'Tui xach tay',
            'parent_id' => 1
        ]);
    }
}
